<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SiteSetting;

class SiteSettingController extends Controller
{

    // get site setting
    public function index()
    {
        App::setLocale('fa');
        $setting = SiteSetting::find(1);
        if ($setting->count() == 1) {
            return response()->json([
                'status' => '200',
                'data' => [
                    'titleFa' => $setting['site_title_fa'],
                    'titleEn' => $setting['site_title_en'],
                    'logoDark' => $setting['logo_dark'],
                    'logoLight' => $setting['logo_light'],
                    'favIcon' => $setting['fav_icon'],
                    'menu' => json_decode($setting['menu']),
                ],
                'time' => jdate($setting->updated_at)->format('H:i Y/m/d')
            ]);
        } else {
            return response()->json([
                'status' => '204',
                'message' => __('status.204')
            ], 200);
        }
    }

    // update admin site settings
    public function update(Request $request, Filesystem $filesystem)
    {
        $setting = SiteSetting::find(1);
        // validate upload
        $this->validate($request, [
            'logo-light' => 'nullable|mimes:jpg,jpeg,png,svg',
            'logo-dark' => 'nullable|mimes:jpg,jpeg,png,svg',
            'fav-icon' => 'nullable|mimes:jpg,jpeg,png,svg'
        ]);
        $imagePath = '/upload/site';
        // logo light upload
        $logoLight = $request->file('logo-light');
        if ($logoLight) {
            $lightName = $logoLight->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$lightName}"))) {
                $lightName = Carbon::now()->timestamp . "-{$lightName}";
            }
            $logoLight->move(public_path($imagePath), $lightName);
        } else {
            $lightName = $setting->logo_light;
        }
        // logo dark upload
        $logoDark = $request->file('logo-dark');
        if ($logoDark) {
            $darkName = $logoDark->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$darkName}"))) {
                $darkName = Carbon::now()->timestamp . "-{$darkName}";
            }
            $logoDark->move(public_path($imagePath), $darkName);
        } else {
            $darkName = $setting->logo_dark;
        }
        // fav icon upload
        $favIcon = $request->file('fav-icon');
        if ($favIcon) {
            $favName = $favIcon->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$favName}"))) {
                $favName = Carbon::now()->timestamp . "-{$favName}";
            }
            $favIcon->move(public_path($imagePath), $favName);
        } else {
            $favName = $setting->fav_icon;
        }
        // update data base
        $setting->site_title_fa = $request->get('title-fa');
        $setting->site_title_en = $request->get('title-en');
        $setting->menu = $request->get('menu');
        $setting->logo_light = $lightName;
        $setting->logo_dark = $darkName;
        $setting->fav_icon = $favName;
        $setting->save();
        return response()->json([
            'status' => '200',
        ], 200);
    }

    // delete admin site logo
    public function delete($text)
    {
        $setting = SiteSetting::find(1);
        if ($text == 'light') {
            $setting->logo_light = '';
            $setting->save();
        } elseif ($text == 'dark') {
            $setting->logo_dark = '';
            $setting->save();
        } elseif ($text == 'fav') {
            $setting->fav_icon = '';
            $setting->save();
        }
        return response()->json([
            'status' => '200',
            $text
        ], 200);
    }

}
