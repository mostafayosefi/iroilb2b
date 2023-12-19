<?php

namespace App\Http\Controllers\User;

use App\Events\AdminNotfication;
use App\Events\UserNotification;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CompanyCollection;
use App\Models\Admin\Advertise;
use App\Models\Admin\Filter;
use App\Models\Admin\Product;
use App\Models\Site\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class CompanyController extends Controller
{
    // add company by user
    public function store(Request $request, Filesystem $filesystem)
    {
        $imagePath = '/upload/company/doc/';
        $logo = $request->get('logo');
        if ($logo) {
            $img = preg_replace('/^data:image\/\w+;base64,/', '', $logo);
            $type = explode(';', $logo)[0];
            $type = explode('/', $type)[1];

            $logoName = "company-" . rand(999, 999999999) . '.' . $type;
            Storage::disk('uploads')->put('/upload/company/logo/' . $logoName, base64_decode($img), 'public');
            $img = Image::make(public_path('/upload/company/logo/' . $logoName));
            $img->resize(300, 300);
            $img->save(public_path('/upload/company/thunb/' . $logoName));
        } else {
            $logoName = null;
        }

        $documentOne = $request->file('document_one');
        if ($documentOne) {
            $documentOneName = $documentOne->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$documentOneName}"))) {
                $documentOneName = Carbon::now()->timestamp . "-{$documentOneName}";
            }
            $documentOne->move(public_path($imagePath), $documentOneName);
        } else {
            $documentOneName = null;
        }
        $documentTow = $request->file('document_tow');
        if ($documentTow) {
            $documentTowName = $documentTow->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$documentTowName}"))) {
                $documentTowName = Carbon::now()->timestamp . "-{$documentTowName}";
            }
            $documentTow->move(public_path($imagePath), $documentTowName);
        } else {
            $documentTowName = null;
        }
        $documentThree = $request->file('document_three');
        if ($documentThree) {
            $documentThreeName = $documentThree->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$documentThreeName}"))) {
                $documentThreeName = Carbon::now()->timestamp . "-{$documentThreeName}";
            }
            $documentThree->move(public_path($imagePath), $documentThreeName);
        } else {
            $documentThreeName = null;
        }
        $data = [];
        $i = 0;
        $lang = $request->get('languages');
        $filters = json_decode($request->get('filters'));
        foreach ($filters as $filter) {
            if ($lang == 'fa') {
                $value = Filter::where('name_fa', $filter)->first();
            } else {
                $value = Filter::where('name_en', $filter)->first();
            }
            $data['filter'][$i] = $value->id;
            $i++;
        }
        $i = 0;
        $tags = json_decode($request->get('tags'));
        foreach ($tags as $tag) {
            if ($lang == 'fa') {
                $value = Product::where('name_fa', $tag)->first();
            } else {
                $value = Product::where('name_en', $tag)->first();
            }
            $data['tag'][$i] = $value->id;
            $i++;
        }

        $company = new Company([
            'users_management' => $request->get('user_management'),
            'status' => 'draft',
            'verified' => 'normal',
            'body_fa' => $request->get('body_fa'),
            'body_en' => $request->get('body_en'),
            'logo' => $logoName,
            'data' => json_encode($data),
            'document_one' => $documentOneName,
            'document_tow' => $documentTowName,
            'document_three' => $documentThreeName,

        ]);
        $company->save();
        event(new AdminNotfication("شرکت جدید ثبت شد."));
        foreach (json_decode($request->get('user_management')) as $user) {
            $user = User::find($user);
            $user->step = 'tow';
            $user->save();
        }

        return response()->json('success', 200);
    }

    // get user company
    public function user(Request $request)
    {
        $lists = Company::all();
        $list = [];
        $i = 0;
        foreach ($lists as $item) {
            foreach (json_decode($item['users_management']) as $user) {
                if ($user == $request->get('id')) {
                    $list[$i]['data']['id'] = $item['id'];
                    $list[$i]['data']['status'] = $item['status'];
                    $list[$i]['data']['slug'] = $item['slug'];
                    $body = json_decode($item['body_fa']);
                    if ($body->name) {
                        $list[$i]['fa']['name'] = $body->name;
                    } else {
                        $list[$i]['fa']['name'] = null;
                    }
                    $body = json_decode($item['body_en']);
                    if ($body->name) {
                        $list[$i]['en']['name'] = $body->name;
                    } else {
                        $list[$i]['en']['name'] = null;
                    }
                    $i++;
                }
            }

        }
        return response()->json($list, 200);

    }

    // show admin company lists
    public function admin(Request $request)
    {
        $lists = Company::orderByDesc('id')->get();
        $list = [];
        $i = 0;
        foreach ($lists as $item) {
            $list[$i]['data']['id'] = $item['id'];
            $list[$i]['data']['status'] = $item['status'];
            $list[$i]['data']['slug'] = $item['slug'];
            $list[$i]['data']['verified'] = $item['verified'];
            $list[$i]['data']['update'] = jdate($item['updated_at'])->format('H:i Y/m/d');
            $list[$i]['data']['create'] = jdate($item['created_at'])->format('H:i Y/m/d');
            $body = json_decode($item['body_fa']);
            if ($body->name) {
                $list[$i]['fa']['name'] = $body->name;
            } else {
                $list[$i]['fa']['name'] = "-";
            }
            $body = json_decode($item['body_en']);
            if ($body->name) {
                $list[$i]['en']['name'] = $body->name;
            } else {
                $list[$i]['en']['name'] = "-";
            }
            $i++;
        }
        return response()->json($list, 200);
    }

    // get admin company
    public function get($id)
    {
        $item = new CompanyCollection(Company::find($id));
        if ($item->count() == 0) {
            return response()->json('null', 200);
        } else {
            return response($item, 200);
        }
    }

    // admin update company
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $data = [];
        $i = 0;
        $filters = json_decode($request->get('filters'));
        foreach ($filters as $filter) {
            $value = Filter::where('name_fa', $filter)->first();
            $data['filter'][$i] = $value->id;
            $i++;
        }
        $i = 0;
        $tags = json_decode($request->get('tags'));
        foreach ($tags as $tag) {
            $value = Product::where('name_fa', $tag)->first();
            $data['tag'][$i] = $value->id;
            $i++;
        }
        $status = $company->status;
        $company->status = $request->get('status');
        $company->slug = $request->get('slug');
        $company->verified = $request->get('verified');
        $company->body_fa = $request->get('body_fa');
        $company->body_en = $request->get('body_en');
        $company->data = json_encode($data);
        $company->save();
        if ($request->get('status') == 'active' and $status != 'active') {
            foreach (json_decode($company->users_management) as $users) {
                $user = User::find($users);

                event(new UserNotification($user, 'company', $request->get('id')));
            }

        }
        return response()->json('success', 200);
    }

    // get single company
    public function single(Request $request, $slug)
    {
        $company = Company::where('slug', $slug)->first();
        if ($company == null) {
            return response()->json('null', 200);
        }
        if ($company->status == 'draft' or $company->status == 'reject') {
            return response()->json('null', 200);
        } else {
            $bodyFa = json_decode($company['body_fa']);
            $bodyEn = json_decode($company['body_en']);

            $data = [];
            $dataCo = json_decode($company['data']);
            if ($dataCo->filter) {
                $i = 0;
                $filters = $dataCo->filter;
                foreach ($filters as $filter) {
                    $value = Filter::find($filter);
                    $data['filter'][$i]['fa'] = $value->name_fa;
                    $data['filter'][$i]['en'] = $value->name_en;
                    $i++;
                }
            }
            if ($dataCo->tag) {
                $products = $dataCo->tag;
                $i = 0;
                foreach ($products as $product) {
                    $value = Product::find($product);
                    $data['tag'][$i]['fa'] = $value->name_fa;
                    $data['tag'][$i]['en'] = $value->name_en;
                    $data['tag'][$i]['link'] = $value->slug;
                    $i++;
                }
            }
            $advertise = Advertise::where('company_id', $company->id)->get();
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
            } else {
                $ad = null;
            }

            if (empty($data['filter'])) {
                $data['filter'] = null;
            }

            if (empty($data['tag'])) {
                $data['tag'] = null;
            }
            return response()->json([
                'verified' => $company->verified,
                'logo' => $company->logo,
                'id' => $company->id,
                'bodyFa' => [
                    'name' => $bodyFa->name != '' ? $bodyFa->name : '-',
                    'seo' => $bodyFa->seo != '' ? $bodyFa->seo : '-',
                    'description' => $bodyFa->description != '' ? $bodyFa->description : '-',
                    'local' => $bodyFa->local != '' ? $bodyFa->local : '-',
                    'adress' => $bodyFa->adress != '' ? $bodyFa->adress : '-',
                    'tell' => $bodyFa->tell != '' ? $bodyFa->tell : '-',
                    'instagram' => $bodyFa->instagram != '' ? $bodyFa->instagram : '-',
                    'facebook' => $bodyFa->facebook != '' ? $bodyFa->facebook : '-',
                    'linkedin' => $bodyFa->linkedin != '' ? $bodyFa->linkedin : '-',
                    'ceo' => [
                        'name' => $bodyFa->ceo->name != '' ? $bodyFa->ceo->name : '-',
                        'email' => $bodyFa->ceo->email != '' ? $bodyFa->ceo->email : '-',
                        'phone' => $bodyFa->ceo->phone != '' ? $bodyFa->ceo->phone : '-'
                    ],
                    'manager' => [
                        'name' => $bodyFa->manager->name != '' ? $bodyFa->manager->name : '-',
                        'email' => $bodyFa->manager->email != '' ? $bodyFa->manager->email : '-',
                        'phone' => $bodyFa->manager->phone != '' ? $bodyFa->manager->phone : '-'
                    ]
                ],
                'bodyEn' => [
                    'name' => $bodyEn->name != '' ? $bodyEn->name : '-',
                    'seo' => $bodyEn->seo != '' ? $bodyEn->seo : '-',
                    'description' => $bodyEn->description != '' ? $bodyEn->description : '-',
                    'local' => $bodyEn->local != '' ? $bodyEn->local : '-',
                    'adress' => $bodyEn->adress != '' ? $bodyEn->adress : '-',
                    'tell' => $bodyEn->tell != '' ? $bodyEn->tell : '-',
                    'instagram' => $bodyEn->instagram != '' ? $bodyEn->instagram : '-',
                    'facebook' => $bodyEn->facebook != '' ? $bodyEn->facebook : '-',
                    'linkedin' => $bodyEn->linkedin != '' ? $bodyEn->linkedin : '-',
                    'ceo' => [
                        'name' => $bodyEn->ceo->name != '' ? $bodyEn->ceo->name : '-',
                        'email' => $bodyEn->ceo->email != '' ? $bodyEn->ceo->email : '-',
                        'phone' => $bodyEn->ceo->phone != '' ? $bodyEn->ceo->phone : '-'
                    ],
                    'manager' => [
                        'name' => $bodyEn->manager->name != '' ? $bodyEn->manager->name : '-',
                        'email' => $bodyEn->manager->email != '' ? $bodyEn->manager->email : '-',
                        'phone' => $bodyEn->manager->phone != '' ? $bodyEn->manager->phone : '-'
                    ]
                ],
                'filters' => $data['filter'],
                'tags' => $data['tag'],
                'ads' => $ad
            ], 200);
        }
    }

    // get all company
    public function all(Request $request)
    {
        $lists = Company::orderByDesc('id')->get();
        $list = [];
        $i = 0;
        foreach ($lists as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                $list[$i]['slug'] = $item['slug'];
                $list[$i]['logo'] = $item['logo'] ? $item['logo'] : '-';
                $list[$i]['verified'] = $item['verified'];
                if ($request->get('language') == 'fa') {
                    $body = json_decode($item['body_fa']);
                    if ($body->name) {
                        $list[$i]['name'] = $body->name;
                    }
                    $i++;
                } else {
                    $body = json_decode($item['body_en']);
                    if ($body->name) {
                        $list[$i]['name'] = $body->name;
                    }
                    $i++;
                }
            }
        }
        return response()->json($list, 200);
    }

    // get company to edit
    public function getCompany($id, Request $request)
    {
        $item = new CompanyCollection(Company::find($id));
        if ($item->count() == 0) {
            return response()->json('null', 200);
        } else {
            foreach (json_decode($item->users_management) as $user) {
                if ($user == $request->get('id')) {
                    return response($item, 200);
                }
            }
            return response()->json('null', 200);
        }
    }

    // user update company
    public function userUpdate(Request $request, $id, Filesystem $filesystem)
    {
        $company = Company::find($id);
        $users = json_decode($company->users_management);
        $status = 0;
        foreach ($users as $user) {
            if ($request->get('user') == $user) {
                $status = 1;
            }
        }
        if ($status == 1) {
            $imagePath = '/upload/company/doc/';
            $logo = $request->get('logo');
            if ($logo) {
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $logo);
                $type = explode(';', $logo)[0];
                $type = explode('/', $type)[1];
                $logoName = "company-" . rand(999, 999999999) . '.' . $type;
                Storage::disk('uploads')->put('/upload/company/logo/' . $logoName, base64_decode($img), 'public');
                $img = Image::make(public_path('/upload/company/logo/' . $logoName));
                $img->resize(300, 300);
                $img->save(public_path('/upload/company/thunb/' . $logoName));
            } else {
                $logoName = $company->logo;
            }

            $documentOne = $request->file('document_one');
            if ($documentOne) {
                $documentOneName = $documentOne->getClientOriginalName();
                if ($filesystem->exists(public_path("{$imagePath}/{$documentOneName}"))) {
                    $documentOneName = Carbon::now()->timestamp . "-{$documentOneName}";
                }
                $documentOne->move(public_path($imagePath), $documentOneName);
            } else {
                $documentOneName = $company->document_one;
            }
            $documentTow = $request->file('document_tow');
            if ($documentTow) {
                $documentTowName = $documentTow->getClientOriginalName();
                if ($filesystem->exists(public_path("{$imagePath}/{$documentTowName}"))) {
                    $documentTowName = Carbon::now()->timestamp . "-{$documentTowName}";
                }
                $documentTow->move(public_path($imagePath), $documentTowName);
            } else {
                $documentTowName = $company->document_tow;
            }
            $documentThree = $request->file('document_three');
            if ($documentThree) {
                $documentThreeName = $documentThree->getClientOriginalName();
                if ($filesystem->exists(public_path("{$imagePath}/{$documentThreeName}"))) {
                    $documentThreeName = Carbon::now()->timestamp . "-{$documentThreeName}";
                }
                $documentThree->move(public_path($imagePath), $documentThreeName);
            } else {
                $documentThreeName = $company->document_three;
            }

            $data = [];
            $i = 0;
            $filters = json_decode($request->get('filters'));
            foreach ($filters as $filter) {
                $value = Filter::where('name_fa', $filter)->first();
                $data['filter'][$i] = $value->id;
                $i++;
            }
            $i = 0;
            $tags = json_decode($request->get('tags'));
            foreach ($tags as $tag) {
                $value = Product::where('name_fa', $tag)->first();
                $data['tag'][$i] = $value->id;
                $i++;
            }
            $company->body_fa = $request->get('body_fa');
            $company->body_en = $request->get('body_en');
            $company->data = json_encode($data);
            $company->logo = $logoName;
            $company->document_one = $documentOneName;
            $company->document_tow = $documentTowName;
            $company->document_three = $documentThreeName;
            $company->save();
            return response()->json('success', 200);
        }
    }

}
