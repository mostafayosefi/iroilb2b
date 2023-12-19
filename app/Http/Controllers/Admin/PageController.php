<?php

namespace App\Http\Controllers\Admin;

use App\Events\Viewer;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PageCollection;
use App\Models\Admin\Page;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PageController extends Controller
{
    // get all page admin
    public function index()
    {
        $pages = Page::all();
        if ($pages->count() == 4) {
            return response()->json('null');
        } else {
            $data = [];
            $i = 0;
            App::setLocale('fa');
            foreach ($pages as $page) {
                if ($page['id'] > 4) {
                    $data[$i]['id'] = $page['id'];
                    $data[$i]['titleFa'] = $page['title_fa'];
                    $data[$i]['titleEn'] = $page['title_en'];
                    $data[$i]['slug'] = $page['type'] . '/' . $page['slug'];
                    $data[$i]['status'] = $page['status'];
                    $data[$i]['time'] = jdate($page['created_at'])->format('H:i Y/m/d');
                    $i++;
                }
            }
            return response()->json($data, 200);
        }
    }

    // store admin page
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

        $imagePath = '/upload/page';
        function saveImage($text, $name)
        {
            if (get_string_between($text, '<img src="data:image/', '"')) {
                $parsed = get_string_between($text, '<img src="', '"');
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $parsed);
                $type = explode(';', $parsed)[0];
                $type = explode('/', $type)[1];
                $imageName = $name . "-" . rand(9999, 9999999) . '.' . $type;
                Storage::disk('uploads')->put('/upload/page/' . strtolower($imageName), base64_decode($img), 'public');
                $text = str_replace($parsed, URL::to('/upload/page/') . "/$imageName", $text);
            }
            return $text;
        }

        $textFa = saveImage($request->get('body_fa'), $request->get('slug'));
        $textEn = saveImage($request->get('body_en'), $request->get('slug'));
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

        $page = new Page([
            'title_fa' => $request->get('title_fa'),
            'title_en' => $request->get('title_en'),
            'slug' => $request->get('slug'),
            'type' => $request->get('type'),
            'status' => $request->get('status'),
            'images' => strtolower($imageName),
            'body_fa' => $textFa,
            'body_en' => $textEn,
            'seo_description_fa' => $request->get('description_fa'),
            'seo_description_en' => $request->get('description_en'),
        ]);
        $page->save();

        return response()->json([
            'status' => '200',
        ], 200);
    }

    // delete page admin
    public function delete($id)
    {
        if ($id > 4) {
            $page = Page::find($id);
            $page->delete();
        }
        return response()->json('successfully deleted', 200);
    }

    // get page admin
    public function edit($id)
    {
        $page = new PageCollection(Page::find($id));
        return response()->json($page, 200);
    }

    // update page admin
    public function update(Request $request, Filesystem $filesystem)
    {
        $page = Page::find($request->get('id'));

        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return false;
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

        $imagePath = '/upload/page';
        function saveImage($text, $name)
        {
            if (get_string_between($text, '<img src="data:image/', '"')) {
                $parsed = get_string_between($text, '<img src="', '"');
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $parsed);
                $type = explode(';', $parsed)[0];
                $type = explode('/', $type)[1];
                $imageName = $name . "-" . rand(9999, 9999999) . '.' . $type;
                Storage::disk('uploads')->put('/upload/page/' . strtolower($imageName), base64_decode($img), 'public');
                $text = str_replace($parsed, URL::to('/upload/page/') . "/$imageName", $text);
            }
            return $text;
        }

        $textFa = saveImage($request->get('body_fa'), $request->get('slug'));
        $textEn = saveImage($request->get('body_en'), $request->get('slug'));
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
            $imageName = $page->images;
        }

        $page->title_fa = $request->get('title_fa');
        $page->title_en = $request->get('title_en');
        $page->slug = $request->get('slug');
        $page->type = $request->get('type');
        $page->status = $request->get('status');
        $page->images = strtolower($imageName);
        $page->body_fa = $textFa;
        $page->body_en = $textEn;
        $page->seo_description_fa = $request->get('description_fa');
        $page->seo_description_en = $request->get('description_en');
        $page->save();

        return response()->json([
            'status' => '200',
        ], 200);
    }

    // update b2b plus page admin
    public function special(Request $request, Filesystem $filesystem)
    {
        $page = Page::find($request->get('id'));
        $imagePath = '/upload/page';
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
                $image->move(public_path($imagePath), $imageName);
            }
        } else {
            $imageName = $page->images;
        }

        $page->images = $imageName;
        $page->body_fa = $request->get('body_fa');
        $page->body_en = $request->get('body_en');
        $page->seo_description_fa = $request->get('description_fa');
        $page->seo_description_en = $request->get('description_en');
        $page->save();

        return response()->json([
            'status' => '200',
        ], 200);
    }

    // get b2b plus admin
    public function get($id)
    {
        App::setLocale('fa');
        $page = Page::find($id);
        if ($id == 4 or $id == 1) {
            $textFa = json_decode($page->body_fa);
            $textEn = json_decode($page->body_en);
        }
        if ($id == 2 or $id == 3) {
            $textFa = $page->body_fa;
            $textEn = $page->body_en;
        }
        return response()->json([
            'status' => '200',
            'data' => [
                'id' => $page->id,
                'titleFa' => $page->title_fa,
                'titleEn' => $page->title_en,
                'slug' => $page->slug,
                'type' => $page->type,
                'status' => $page->status,
                'images' => $page->images,
                'bodyFa' => $textFa,
                'bodyEn' => $textEn,
                'seoDescriptionFa' => $page->seo_description_fa == null ? '' : $page->seo_description_fa,
                'seoDescriptionEn' => $page->seo_description_en == null ? '' : $page->seo_description_en,
            ],
            'time' => jdate($page->updated_at)->format('H:i Y/m/d')
        ], 200);
    }

    // get user home page
    public function home()
    {
        $one = Page::where('slug', 'home')->first();
        if ($one == null) {
            return response()->json('null', 200);
        }
        $page = new PageCollection($one);
        event(new Viewer('page', $page->id));
        $textFa = json_decode($page->body_fa);
        $textEn = json_decode($page->body_en);
        return response()->json([
            'status' => '200',
            'data' => [
                'titleFa' => $page->title_fa,
                'titleEn' => $page->title_en,
                'bodyFa' => $textFa,
                'bodyEn' => $textEn,
                'seoDescriptionFa' => $page->seo_description_fa == null ? '' : $page->seo_description_fa,
                'seoDescriptionEn' => $page->seo_description_en == null ? '' : $page->seo_description_en,
            ],
        ], 200);
    }
}
