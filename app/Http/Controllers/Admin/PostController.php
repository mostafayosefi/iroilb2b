<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostCollection;
use App\Models\Admin\Category;
use App\Models\Admin\Post;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PostController extends Controller
{
    // get all admin post
    public function index()
    {
        $posts = Post::orderByDesc('id')->get();
        $categories = Category::with('parent')->whereNull('parent_id')->get();
        $subcategories = Category::with('parent')->whereNotNull('parent_id')->get();
        if ($posts->count() == 0) {
            return response()->json('null');
        } else {
            $data = [];
            $i = 0;
            App::setLocale('fa');
            foreach ($posts as $post) {
                if ($post['categories'] == null) {
                    $cat = [__('status.no-cat')];
                } else {
                    $cats = explode(",", $post['categories']);
                    $cat = [];
                    foreach ($cats as $ct) {
                        foreach ($categories as $category) {
                            if ($ct == $category['id']) {
                                $cat[$i] = $category['title_fa'];
                            }
                        }
                        foreach ($subcategories as $subCat) {
                            if ($ct == $subCat['id']) {
                                $cat[$i] = $subCat['title_fa'];
                            }
                        }
                    }
                }
                $data[$i]['id'] = $post['id'];
                $data[$i]['title'] = $post['title'];
                $data[$i]['slug'] = $post['slug'];
                $data[$i]['language'] = $post['language'];
                $data[$i]['categories'] = $cat;
                $data[$i]['status'] = $post['status'];
                $data[$i]['time'] = jdate($post['created_at'])->format('H:i Y/m/d');
                $i++;
            }
            return response()->json($data, 200);
        }
    }

    // store admin post
    public function store(Request $request, Filesystem $filesystem)
    {
        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return false;
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

        $imagePath = '/upload/post';
        function saveImage($text, $name)
        {
            if (get_string_between($text, '<img src="data:image/', '"')) {
                $parsed = get_string_between($text, '<img src="', '"');
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $parsed);
                $type = explode(';', $parsed)[0];
                $type = explode('/', $type)[1];

                $imageName = $name . "-" . rand(9999, 9999999) . '.' . $type;
                Storage::disk('uploads')->put('/upload/post/' . strtolower($imageName), base64_decode($img), 'public');
                $text = str_replace($parsed, URL::to('/upload/post/') . "/$imageName", $text);
            }
            return $text;
        }

        $text = saveImage($request->get('body'), $request->get('slug'));
        $this->validate($request, [
            'images' => 'nullable|mimes:jpg,jpeg,png,svg,webp',
        ]);
        $image = $request->file('images');

        if ($image) {
            $imageName = $image->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$imageName}"))) {
                $imageName = Carbon::now()->timestamp . "-{$imageName}";
            }
            $image->move(public_path($imagePath), strtolower($imageName));
        } else {
            $imageName = null;
        }

        $post = new Post([
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'language' => $request->get('language'),
            'status' => $request->get('status'),
            'images' => strtolower($imageName),
            'user_id' => $request->get('user_id'),
            'categories' => $request->get('categories'),
            'labels' => $request->get('labels'),
            'body' => $text,
            'seo_description' => $request->get('seo_description'),
            'seo_kaywords' => $request->get('seo_kaywords'),
        ]);
        $post->save();

        event(new SendNotification('email', [
            'title' => $request->get('title'),
            'link' => URL::to('/' . $request->get('language') . '/post/' . $request->get('slug')),
            'image' => URL::to('/upload/post/' . strtolower($imageName)),
            'text' => mb_substr(strip_tags($text), 0, 200)
        ]));
        return response()->json([
            'status' => '200',
        ], 200);
    }

    // delete admin post
    public function delete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json('successfully deleted', 200);
    }

    // get admin post
    public function edit($id)
    {
        $post = new PostCollection(Post::find($id));
        return response()->json($post, 200);
    }

    // update admin post
    public function update(Request $request, Filesystem $filesystem)
    {
        $post = Post::find($request->get('id'));

        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return false;
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

        $imagePath = '/upload/post';
        function saveImage($text, $name)
        {
            if (get_string_between($text, '<img src="data:image/', '"')) {
                $parsed = get_string_between($text, '<img src="', '"');
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $parsed);
                $type = explode(';', $parsed)[0];
                $type = explode('/', $type)[1];
                $imageName = $name . "-" . rand(9999, 9999999) . '.' . $type;
                Storage::disk('uploads')->put('/upload/post/' . strtolower($imageName), base64_decode($img), 'public');
                $text = str_replace($parsed, URL::to('/upload/post/') . "/$imageName", $text);
            }
            return $text;
        }

        $text = saveImage($request->get('body'), $request->get('slug'));
        if ($request->file('images') != null) {
            $this->validate($request, [
                'images' => 'nullable|mimes:jpg,jpeg,png,svg,webp',
            ]);
            $image = $request->file('images');
            if ($image) {
                $imageName = $image->getClientOriginalName();
                if ($filesystem->exists(public_path("{$imagePath}/{$imageName}"))) {
                    $imageName = Carbon::now()->timestamp . "-{$imageName}";
                }
                $image->move(public_path($imagePath), strtolower($imageName));
            }
        } else {
            $imageName = $post->images;
        }

        $post->title = $request->get('title');
        $post->slug = $request->get('slug');
        $post->language = $request->get('language');
        $post->status = $request->get('status');
        $post->images = strtolower($imageName);
        $post->categories = $request->get('categories');
        $post->labels = $request->get('labels');
        $post->body = $text;
        $post->seo_description = $request->get('seo_description');
        $post->seo_kaywords = $request->get('seo_kaywords');
        $post->save();

        return response()->json([
            'status' => '200',
        ], 200);
    }

}
