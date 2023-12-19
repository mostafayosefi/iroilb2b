<?php

namespace App\Http\Controllers\User;

use App\Events\Viewer;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostCollection;
use App\Models\Admin\Category;
use App\Models\Admin\Labels;
use App\Models\Admin\Post;
use App\Models\Site\RatePost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // for home page
    public function index(Request $request)
    {
        $query = Post::where('language', $request->get('lang'))->first();
        if ($query == null) {
            return response()->json('null', 200);
        }
        $query = Post::orderByDesc('id')->where('language', $request->get('lang'))->get();
        $i = 0;
        $data = [];
        foreach ($query as $item) {
            if ($item['status'] == 'publish') {
                $data['data'][$i]['image'] = $item['images'];
                $data['data'][$i]['title'] = $item['title'];
                $data['data'][$i]['slug'] = $item['slug'];
                $data['data'][$i]['text'] = mb_substr(strip_tags($item['body']), 0, 100);
                if ($request->get('lang') == 'fa') {
                    $data['data'][$i]['time'] = jdate($item['updated_at'])->format('H:i Y/m/d');
                } else {
                    $data['data'][$i]['time'] = $item['updated_at']->format('Y/m/d H:i');
                }
                $i++;
            }
        }
        $categories = Category::all();
        $j = 0;
        $category = [];
        foreach ($categories as $item) {
            $posts = Post::where('status', 'publish')->get();
            foreach ($posts as $post) {
                $cats = explode(",", $post->categories);
                if (in_array($item->id, $cats)) {
                    if ($request->get('lang') == 'fa') {
                        $category[$j]['title'] = $item['title_fa'];
                    } else {
                        $category[$j]['title'] = $item['title_en'];
                    }
                    $category[$j]['slug'] = $item['slug'];
                    $j++;
                }
            }
        }
        $category = array_unique($category, SORT_REGULAR);
        $j = 0;
        $categories = [];
        foreach ($category as $item) {
            $categories[$j]['title'] = $item['title'];
            $categories[$j]['slug'] = $item['slug'];
            $j++;
        }
        $data['cat'] = $categories;
        if ($i == 0) {
            return response()->json('null', 200);
        } else {
            return response()->json($data, 200);
        }
    }

    // show post categories
    public function categories(Request $request)
    {
        $cat = Category::where('slug', $request->get('slug'))->first();
        if ($cat == null) {
            return response()->json('null', 200);
        }

        $query = Post::where('language', $request->get('lang'))->first();
        if ($query == null) {
            return response()->json('null', 200);
        }
        $query = Post::orderByDesc('id')->where('language', $request->get('lang'))->get();
        $i = 0;
        $data = [];
        foreach ($query as $item) {
            if ($item['categories'] != null and $item['status'] == 'publish') {
                $cats = explode(",", $item['categories']);
                if ($request->get('lang') == 'fa') {
                    $data['cat']['title'] = $cat['title_fa'];
                    $data['cat']['description'] = $cat['description_fa'];
                } else {
                    $data['cat']['title'] = $cat['title_en'];
                    $data['cat']['description'] = $cat['description_en'];
                }
                if (in_array($cat->id, $cats)) {
                    $data['data'][$i]['image'] = $item['images'];
                    $data['data'][$i]['title'] = $item['title'];
                    $data['data'][$i]['slug'] = $item['slug'];
                    $data['data'][$i]['text'] = mb_substr(strip_tags($item['body']), 0, 200);
                    if ($request->get('lang') == 'fa') {
                        $data['data'][$i]['time'] = jdate($item['updated_at'])->format('H:i Y/m/d');
                    } else {
                        $data['data'][$i]['time'] = $item['updated_at']->format('Y/m/d H:i');
                    }
                    $i++;
                }
            }
        }
        if ($i == 0) {
            return response()->json('null', 200);
        } else {
            return response()->json($data, 200);
        }
    }

    // show post labels
    public function labels(Request $request)
    {
        $label = Labels::where('slug', $request->get('slug'))->first();
        if ($label == null) {
            return response()->json('null', 200);
        }

        $query = Post::where('language', $request->get('lang'))->first();
        if ($query == null) {
            return response()->json('null', 200);
        }
        $query = Post::orderByDesc('id')->where('language', $request->get('lang'))->get();
        $i = 0;
        $data = [];
        foreach ($query as $item) {
            if ($item['labels'] != null and $item['status'] == 'publish') {
                $labels = explode(",", $item['labels']);
                $data['label']['title'] = $label['title'];
                $data['label']['description'] = $label['description'];
                if (in_array($label->title, $labels)) {
                    $data['data'][$i]['image'] = $item['images'];
                    $data['data'][$i]['title'] = $item['title'];
                    $data['data'][$i]['slug'] = $item['slug'];
                    $data['data'][$i]['text'] = mb_substr(strip_tags($item['body']), 0, 200);
                    if ($request->get('lang') == 'fa') {
                        $data['data'][$i]['time'] = jdate($item['updated_at'])->format('H:i Y/m/d');
                    } else {
                        $data['data'][$i]['time'] = $item['updated_at']->format('Y/m/d H:i');
                    }
                    $i++;
                }
            }

        }
        if ($i == 0) {
            return response()->json('null', 200);
        } else {
            return response()->json($data, 200);
        }
    }

    // show single post
    public function post(Request $request, $slug)
    {
        $one = Post::where('slug', $slug)->first();
        if ($one == null) {
            return response()->json('null', 200);
        }
        $post = new PostCollection($one);
        if ($post->status == 'draft' or $post->language != $request->get('lang')) {
            return response()->json('null', 200);
        } else {
            $data = [];
            if ($post->categories != null) {
                $j = 0;
                $categories = [];
                $cats = explode(",", $post->categories);
                foreach ($cats as $rows) {
                    $cat = Category::where('id', $rows)->first();
                    if ($request->get('lang') == 'fa') {
                        $categories[$j]['title'] = $cat['title_fa'];
                    } else {
                        $categories[$j]['title'] = $cat['title_en'];
                    }
                    $categories[$j]['slug'] = $cat['slug'];
                    $j++;
                }
                $cat = array_merge($categories);
                $query = Post::orderByDesc('id')->where('language', $request->get('lang'))->limit(4)->get()->except($post->id);
                if ($query->count() > 0) {
                    $m = 0;
                    foreach ($query as $item) {
                        if ($m < 3) {
                            $data[$m]['image'] = $item['images'];
                            $data[$m]['title'] = $item['title'];
                            $data[$m]['slug'] = $item['slug'];
                            $data[$m]['text'] = mb_substr(strip_tags($item['body']), 0, 100);
                            if ($request->get('lang') == 'fa') {
                                $data[$m]['time'] = jdate($item['updated_at'])->format('H:i Y/m/d');
                            } else {
                                $data[$m]['time'] = $item['updated_at']->format('Y/m/d H:i');
                            }
                        } else {
                            break;
                        }
                        $m++;
                    }
                } else {
                    $data = null;
                }
            } else {
                $cat = null;
                $data = null;
            }
            if ($post->labels != null) {
                $k = 0;
                $labels = [];
                $labelsList = explode(",", $post->labels);
                foreach ($labelsList as $rows) {
                    $label = Labels::where('title', $rows)->first();
                    $labels[$k]['title'] = $label['title'];
                    $labels[$k]['slug'] = $label['slug'];
                    $k++;
                }
                $label = array_merge($labels);
            } else {
                $label = null;
            }

            if ($request->get('lang') == 'fa') {
                $time = jdate($post->updated_at)->format('H:i Y/m/d');
            } else {
                $time = date("Y/m/d H:i", strtotime($post->updated_at));
            }
            if ($request->get('lang') == 'fa') {
                $created = jdate($post->created_at)->format('H:i Y/m/d');
            } else {
                $created = date("Y/m/d H:i", strtotime($post->created_at));
            }
            $rates = RatePost::where('post_id', $post->id)->get();

            if ($rates->count() > 0) {
                $count = 0;
                foreach ($rates as $rate) {
                    $count += $rate->rate;
                }
                $count = $count / $rates->count();
                $user = $rates->count();
            } else {
                $count = 5;
                $user = 1;
            }
            event(new Viewer('post', $post->id));
            return response()->json([
                'post' => $post,
                'cat' => $cat,
                'label' => $label,
                'related' => $data,
                'rate' => $count,
                'count' => $user,
                'time' => $time,
                'created' => $created,
            ], 200);
        }
    }

    // add rate post
    public function rate(Request $request)
    {
        $rate = new RatePost([
            'post_id' => $request->get('post'),
            'rate' => $request->get('rate')
        ]);
        $rate->save();
        return response()->json('success', 200);
    }

}
