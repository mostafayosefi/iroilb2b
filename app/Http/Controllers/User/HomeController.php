<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Advertise;
use App\Models\Admin\Post;
use App\Models\Admin\Product;
use App\Models\Admin\Redirect;
use App\Models\Admin\SiteSetting;
use App\Models\Site\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{
    // home view
    public function index()
    {
        $setting = SiteSetting::find(1);
        $redirects = Redirect::all();
        $link = explode(URL::to('/'), url()->current());
        if ($redirects->count() > 0) {
            foreach ($redirects as $redirect) {
                if ($link[1] == $redirect->link) {
                    return redirect($redirect->redirect, $redirect->status);
                }
            }
        }

        return view('user/app', ['setting' => $setting, 'data' => '2']);
    }

    // search page
    public function tags()
    {
        $tags = Product::all();
        $i = 0;
        $data = [];
        foreach ($tags as $tag) {
            $companies = Company::all();
            foreach ($companies as $company) {
                $body = json_decode($company['data']);
                if ($body->tag) {
                    foreach ($body->tag as $item) {
                        if ($tag['id'] == $item) {
                            if (isset($data[0])) {
                                $count = 0;
                                foreach ($data as $row) {
                                    if ($row['id'] == $tag['id']) {
                                        $count = 1;
                                    }
                                }
                                if ($count == 0) {
                                    $data[$i]['id'] = $tag['id'];
                                    $data[$i]['fa'] = $tag['name_fa'];
                                    $data[$i]['en'] = $tag['name_en'];
                                    $data[$i]['link'] = $tag['slug'];
                                }
                            } else {
                                $data[$i]['id'] = $tag['id'];
                                $data[$i]['fa'] = $tag['name_fa'];
                                $data[$i]['en'] = $tag['name_en'];
                                $data[$i]['link'] = $tag['slug'];
                            }
                            $i++;
                        }
                    }
                }
            }
        }
        $i = 0;
        $tags = [];
        foreach ($data as $tag) {
            $tags[$i]['id'] = $tag['id'];
            $tags[$i]['fa'] = $tag['fa'];
            $tags[$i]['en'] = $tag['en'];
            $tags[$i]['link'] = $tag['link'];
            $i++;
        }
        return response()->json($tags, 200);
    }

    // search input
    public function search($text, Request $request)
    {
        $company = Company::all();
        $advertise = Advertise::all();
        $post = Post::all();
        $companies = [];
        $ads = [];
        $posts = [];
        $i = 0;
        $j = 0;
        $k = 0;
        foreach ($company as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                if (preg_match('/[^A-Za-z0-9]/', $text)) {
                    $body = json_decode($item['body_fa']);
                    if ($body->name and stripos($body->name, $text) !== false) {
                        $companies[$i] = [
                            'name' => $body->name,
                            'slug' => $item['slug'],
                            'logo' => $item['logo'] ? $item['logo'] : '-',
                            'verified' => $item['verified']
                        ];
                        $i++;
                    } else {
                        $data = json_decode($item['data']);
                        if ($data->tag) {
                            $products = $data->tag;
                            foreach ($products as $product) {
                                $value = Product::find($product);
                                if (stripos($value->name_fa, $text) !== false) {
                                    $companies[$i] = [
                                        'name' => $body->name,
                                        'slug' => $item['slug'],
                                        'logo' => $item['logo'] ? $item['logo'] : '-',
                                        'verified' => $item['verified']
                                    ];
                                    $i++;
                                }
                            }
                        }
                    }
                } else {
                    $body = json_decode($item['body_en']);
                    if ($body->name and stripos($body->name, $text) !== false) {
                        $companies[$i] = [
                            'name' => $body->name,
                            'slug' => $item['slug'],
                            'logo' => $item['logo'] ? $item['logo'] : '-',
                            'verified' => $item['verified']
                        ];
                        $i++;
                    } else {
                        $data = json_decode($item['data']);
                        if ($data->tag) {
                            $products = $data->tag;
                            foreach ($products as $product) {
                                $value = Product::find($product);
                                if (stripos($value->name_en, $text) !== false) {
                                    $companies[$i] = [
                                        'name' => $body->name,
                                        'slug' => $item['slug'],
                                        'logo' => $item['logo'] ? $item['logo'] : '-',
                                        'verified' => $item['verified']
                                    ];
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($advertise as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                $bodyAd = json_decode($item['body']);
                if ($bodyAd->title and stripos($bodyAd->title, $text) !== false) {
                    $ads[$j] = [
                        'slug' => $item['slug'],
                        'language' => $item['language'],
                        'type' => $item['type'],
                        'title' => $bodyAd->title,
                        'expireFa' => jdate($item['expire_at'])->format('Y/m/d'),
                        'expireEn' => date('Y/m/d', $item['expire_at'])
                    ];
                    $j++;
                } else {
                    if ($bodyAd->tags) {
                        $products = $bodyAd->tags;
                        foreach ($products as $product) {
                            $value = Product::find($product);
                            if (stripos($value->name_en, $text) !== false) {
                                $ads[$j] = [
                                    'slug' => $item['slug'],
                                    'language' => $item['language'],
                                    'type' => $item['type'],
                                    'title' => $bodyAd->title,
                                    'expireFa' => jdate($item['expire_at'])->format('Y/m/d'),
                                    'expireEn' => date('Y/m/d', $item['expire_at'])
                                ];
                                $j++;
                            } else if (stripos($value->name_fa, $text) !== false) {
                                $ads[$j] = [
                                    'slug' => $item['slug'],
                                    'language' => $item['language'],
                                    'type' => $item['type'],
                                    'title' => $bodyAd->title,
                                    'expireFa' => jdate($item['expire_at'])->format('Y/m/d'),
                                    'expireEn' => date('Y/m/d', $item['expire_at'])
                                ];
                                $j++;
                            }
                        }
                    }
                }
            }
        }

        foreach ($post as $item) {
            if ($item['status'] == 'publish') {
                if (stripos($item['title'], $text) !== false) {
                    $posts[$k] = [
                        'slug' => $item['slug'],
                        'language' => $item['language'],
                        'image' => $item['images'],
                        'title' => $item['title'],
                        'text' => mb_substr(strip_tags($item['body']), 0, 100),
                        'time' => $request->get('language') == 'fa' ? jdate($item['updated_at'])->format('H:i Y/m/d') : $item['updated_at']->format('Y/m/d H:i'),
                    ];
                    $k++;
                } else {
                    if (stripos($item['labels'], $text) !== false) {
                        $posts[$k] = [
                            'slug' => $item['slug'],
                            'language' => $item['language'],
                            'type' => $item['type'],
                            'title' => $item['title'],
                            'text' => mb_substr(strip_tags($item['body']), 0, 100),
                            'time' => $request->get('language') == 'fa' ? jdate($item['updated_at'])->format('H:i Y/m/d') : $item['updated_at']->format('Y/m/d H:i'),
                        ];
                        $k++;
                    }
                }
            }
        }
        $data = [
            'search' => $text,
            'companies' => $companies,
            'ads' => $ads,
            'posts' => $posts
        ];
        return response()->json($data, 200);
    }

    // show filter tags
    public function filter(Request $request, $slug)
    {
        $company = Company::all();
        $advertise = Advertise::all();
        $companies = [];
        $ads = [];
        $i = 0;
        $j = 0;
        $check = Product::where('slug', $slug)->first();
        if ($check == null) {
            return response()->json('null', 200);
        }
        foreach ($company as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                if ('fa' == $request->get('languages')) {
                    $body = json_decode($item['body_fa']);
                    $data = json_decode($item['data']);
                    if ($data->tag) {
                        $products = $data->tag;
                        foreach ($products as $product) {
                            $value = Product::find($product);
                            if ($value->slug == $check->slug) {
                                $companies[$i] = [
                                    'name' => $body->name,
                                    'slug' => $item['slug'],
                                    'logo' => $item['logo'] ? $item['logo'] : '-',
                                    'verified' => $item['verified']
                                ];
                                $i++;
                            }
                        }
                    }
                } else {
                    $body = json_decode($item['body_en']);
                    $data = json_decode($item['data']);
                    if ($data->tag) {
                        $products = $data->tag;
                        foreach ($products as $product) {
                            $value = Product::find($product);
                            if ($value->slug == $check->slug) {
                                $companies[$i] = [
                                    'name' => $body->name,
                                    'slug' => $item['slug'],
                                    'logo' => $item['logo'] ? $item['logo'] : '-',
                                    'verified' => $item['verified']
                                ];
                                $i++;
                            }
                        }
                    }
                }
            }
        }
        foreach ($advertise as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                $bodyAd = json_decode($item['body']);
                if ($bodyAd->tags) {
                    $products = $bodyAd->tags;
                    foreach ($products as $product) {
                        $value = Product::find($product);
                        if (stripos($value->slug, $check->slug) !== false) {
                            $ads[$j] = [
                                'slug' => $item['slug'],
                                'language' => $item['language'],
                                'type' => $item['type'],
                                'title' => $bodyAd->title,
                                'expireFa' => jdate($item['expire_at'])->format('Y/m/d'),
                                'expireEn' => date('Y/m/d', $item['expire_at'])
                            ];
                            $j++;
                        }
                    }
                }
            }
        }
        $data = [
            'titleFa' => $check->name_fa,
            'titleEn' => $check->name_en,
            'companies' => $companies,
            'ads' => $ads
        ];
        return response()->json($data, 200);
    }

    // google login
    public function auth()
    {
        $auth = Socialite::driver('google')->stateless()->user();
        $name=explode("@gmail.com", $auth->email);
        $user = User::firstOrCreate(['email' => $auth->email], [
            'name' => $name[0],
            'role' => 'user',
            'is_active' => 1,
            'phone_verified' => 0,
            'email_verified' => 1,
            'email' => $auth->email,
            'phone' => null,
            'password' => bcrypt(rand(1000000, 9999999)),
            'api_token' => Str::random(100)
        ]);
        if ($user) {
            return redirect(URL::to("/en/account?id={$user->id}&role={$user->role}&token={$user->api_token}"));
        } else {
            return redirect(URL::to("/"));
        }
    }
}
