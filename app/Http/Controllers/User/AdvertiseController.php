<?php

namespace App\Http\Controllers\User;

use App\Events\AdminNotfication;
use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use App\Models\Admin\Advertise;
use App\Models\Admin\Product;
use App\Models\Site\Company;
use App\Models\Site\FavoriteAdvertise;
use App\Models\User;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    // get all advertise
    public function index()
    {
        $advertises = Advertise::orderByDesc('id')->get();
        if ($advertises->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $i = 0;
            foreach ($advertises as $item) {
                $company = Company::find($item['company_id']);
                $body = json_decode($company->body_fa);
                if ($body->name) {
                    $data[$i]['company']['fa'] = $body->name;
                } else {
                    $data[$i]['company']['fa'] = "-";
                }
                $body = json_decode($company->body_en);
                if ($body->name) {
                    $data[$i]['company']['en'] = $body->name;
                } else {
                    $data[$i]['company']['en'] = "-";
                }
                $data[$i]['company']['verfied'] = $company->verified;
                $body = json_decode($item['body']);
                $data[$i]['id'] = $item['id'];
                $data[$i]['title'] = $body->title;
                $data[$i]['slug'] = $item['slug'];
                $data[$i]['language'] = $item['language'];
                $data[$i]['status'] = $item['status'];
                $data[$i]['type'] = $item['type'] == 'sale' ? 'فروش' : 'خرید';
                $data[$i]['expire'] = jdate($item['expire_at'])->format('Y/m/d');
                $data[$i]['time'] = jdate($item['created_at'])->format('H:i Y/m/d');
                $i++;
            }
            return response()->json($data, 200);
        }
    }

    // user add advertise
    public function store(Request $request)
    {
        $data = [];
        $i = 0;
        $body = $request->get('body');
        foreach ($body['tags'] as $tag) {
            if ($request->get('language') == 'fa') {
                $value = Product::where('name_fa', $tag)->first();
            } else {
                $value = Product::where('name_en', $tag)->first();
            }
            $data['tag'][$i] = $value->id;
            $i++;
        }
        $body['tags'] = $data['tag'];
        $advertise = new Advertise([
            'company_id' => $request->get('company_id'),
            'slug' => $body['title'],
            'status' => 'draft',
            'language' => $request->get('language'),
            'body' => json_encode($body),
            'type' => $request->get('type'),
            'expire_at' => strtotime($request->get('expire'))
        ]);
        $advertise->save();
        if ($request->get('step') == 'tow') {
            $user = User::find(intval($request->get('id')));
            $user->step = 'three';
            $user->save();
        }
        event(new AdminNotfication("آگهی  جدید ثبت شد."));
        return response()->json('success', 200);
    }

    // get user advertise
    public function user($id)
    {
        $lists = Advertise::where('company_id', intval($id))->get();
        $list = [];
        $i = 0;
        foreach ($lists as $item) {
            if ($item['status'] != 'deleted') {
                $list[$i]['id'] = $item['id'];
                $list[$i]['status'] = $item['status'];
                $list[$i]['slug'] = $item['slug'];
                $list[$i]['type'] = $item['type'];
                $list[$i]['language'] = $item['language'];
                if ($item['language'] == 'fa') {
                    $list[$i]['time'] = jdate($item['expire_at'])->format('Y/m/d');
                } else {
                    $list[$i]['time'] = date("H/m/d", $item['expire_at']);
                }
                if ($item['expire_at'] < time()) {
                    $ad = Advertise::find($item['id']);
                    $ad->status = 'timeout';
                    $ad->save();
                    $list[$i]['status'] = 'timeout';
                }
                $body = json_decode($item['body']);
                $list[$i]['title'] = $body->title;
                $i++;
            }
        }
        return response()->json($list, 200);
    }

    // get admin delete
    public function delete($id)
    {
        $adv = Advertise::find($id);
        $adv->delete();
        return response()->json('successfully deleted', 200);
    }

    // get admin advertise
    public function get($id)
    {
        $ads = Advertise::find($id);
        if ($ads->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $data['id'] = $ads['id'];
            $data['type'] = $ads['type'];
            $data['language'] = $ads['language'];
            $data['slug'] = $ads['slug'];
            $company = Company::find($ads['company_id']);
            $body = json_decode($company->body_fa);
            if ($body->name) {
                $data['company']['fa'] = $body->name;
            } else {
                $data['company']['fa'] = "-";
            }
            $body = json_decode($company->body_en);
            if ($body->name) {
                $data['company']['en'] = $body->name;
            } else {
                $data['company']['en'] = "-";
            }
            $data['status'] = $ads['status'];
            $data['body'] = json_decode($ads['body']);
            $data['time'] = jdate($ads['expire_at'])->format('Y/m/d');
            return response()->json($data, 200);
        }
    }

    // update admin advertise
    public function update(Request $request, $id)
    {
        $ads = Advertise::find($id);
        $status = $ads->status;
        $ads->slug = $request->get('slug');
        $ads->type = $request->get('type');
        $ads->language = $request->get('language');
        $ads->status = $request->get('status');
        $ads->body = $request->get('body');
        $ads->save();
        if ($status != 'draft' and $request->get('status') == 'active') {
            event(new SendNotification('sms'));
        }
        return response()->json('success', 200);
    }

    // user delete advertise
    public function trash(Request $request)
    {
        $ads = Advertise::find($request->get('ads'));
        $ads->status = 'deleted';
        $ads->save();
        return response()->json('success', 200);
    }

    // show single ads
    public function single($slug, Request $request)
    {
        $ads = Advertise::where('slug', $slug)->first();
        if ($ads == null or $ads->status == 'draft' or $ads->status == 'reject' or $ads->status == 'deleted') {
            return response()->json('null', 200);
        } else {
            $data = [];
            $data['id'] = $ads['id'];
            $data['type'] = $ads['type'];
            $data['language'] = $ads['language'];
            $data['slug'] = $ads['slug'];
            $company = Company::find($ads['company_id']);
            $body = json_decode($company->body_fa);
            if ($body->name) {
                $data['company']['fa'] = $body->name;
            } else {
                $data['company']['fa'] = "-";
            }
            $body = json_decode($company->body_en);
            if ($body->name) {
                $data['company']['en'] = $body->name;
            } else {
                $data['company']['en'] = "-";
            }

            $tags = json_decode($ads['body']);
            if ($tags->tags) {
                $products = $tags->tags;
                $i = 0;
                $advertise = Advertise::where([['language', $ads['language']], ['id', '!=', $ads['id']]])->orderByDesc('id')->get();
                $relatedAds = [];
                $j = 0;

                foreach ($products as $product) {
                    $value = Product::find($product);
                    $data['tags'][$i]['fa'] = $value->name_fa;
                    $data['tags'][$i]['en'] = $value->name_en;
                    $data['tags'][$i]['link'] = $value->slug;
                    $i++;
                    foreach ($advertise as $item) {
                        if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                            $bodyAd = json_decode($item['body']);
                            if ($bodyAd->tags) {
                                $productsAds = $bodyAd->tags;
                                foreach ($productsAds as $row) {
                                    if ($row == $product) {
                                        if ($j == 3)
                                            break;
                                        $relatedAds[$j] = [
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
            }
            if ($request->get('user') != '-') {
                $favorite = FavoriteAdvertise::where([
                    ['user_id', $request->get('user')],
                    ['ads_id', $ads['id']],
                ])->first();
                if ($favorite) {
                    $data['bookmark'] = true;
                } else {
                    $data['bookmark'] = false;
                }
            } else {
                $data['bookmark'] = false;
            }
            $data['related'] = $relatedAds;
            $data['company']['verified'] = $company->verified;
            $data['company']['link'] = $company->slug;
            $data['body'] = json_decode($ads['body']);
            $data['expire'] = $ads['language'] == 'fa' ? jdate($ads['expire_at'])->format('Y/m/d') : date('Y/m/d', $ads['expire_at']);
            $data['time'] = date('Y/m/d', $ads['expire_at']);
            return response()->json($data, 200);
        }
    }

    // get all advertise
    public function all(Request $request)
    {
        $advertise = Advertise::orderByDesc('id')->where('language', $request->get('language'))->get();
        $ad = null;
        if ($advertise->count() > 0) {
            $ad = [];
            $i = 0;
            foreach ($advertise as $ads) {
                if ($ads['status'] == 'active' or $ads['status'] == 'timeout') {
                    $bodyAd = json_decode($ads['body']);
                    $ad[$i] = [
                        'slug' => $ads['slug'],
                        'language' => $ads['language'],
                        'type' => $ads['type'],
                        'title' => $bodyAd->title,
                        'expireFa' => jdate($ads['expire_at'])->format('Y/m/d'),
                        'expireEn' => date('Y/m/d', $ads['expire_at'])
                    ];
                    $i++;
                }
            }
        }
        return response()->json($ad, 200);
    }

    // get user bookmarks advertise
    public function bookmark(Request $request)
    {
        $bookmarks = FavoriteAdvertise::where([
            ['user_id', $request->get('user')],
        ])->get();
        $ad = null;
        if ($bookmarks->count() > 0) {
            $ad = [];
            $i = 0;
            foreach ($bookmarks as $bookmark) {
                $ads = Advertise::find($bookmark['ads_id']);
                if ($ads['status'] == 'active' or $ads['status'] == 'timeout') {
                    $bodyAd = json_decode($ads['body']);
                    $ad[$i] = [
                        'slug' => $ads['slug'],
                        'language' => $ads['language'],
                        'type' => $ads['type'],
                        'title' => $bodyAd->title,
                        'expireFa' => jdate($ads['expire_at'])->format('Y/m/d'),
                        'expireEn' => date('Y/m/d', $ads['expire_at'])
                    ];
                    $i++;
                }
            }
        }
        return response()->json($ad, 200);
    }

    // add favorite
    public function favoriteAdd(Request $request)
    {
        $favorite = new FavoriteAdvertise([
            'user_id' => $request->input('user'),
            'ads_id' => $request->input('ads'),
        ]);
        $favorite->save();
        return response()->json([
            'status' => 200
        ], 200);
    }

    // remove favorite
    public function favoriteDelete(Request $request)
    {
        FavoriteAdvertise::where([
            ['user_id', $request->get('user')],
            ['ads_id', $request->input('ads')],
        ])->delete();
        return response()->json([
            'status' => 200
        ], 200);
    }
}
