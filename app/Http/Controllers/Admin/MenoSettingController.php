<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MenoSetting;
use Illuminate\Http\Request;

class MenoSettingController extends Controller
{
    // get user meno
    public function index()
    {
        $meno = MenoSetting::find(1);
        $footer = MenoSetting::find(2);
        return response()->json([
            'meno' => json_decode($meno->meno),
            'footer' => json_decode($footer->meno)
        ]);
    }

    // update meno desktop admin
    public function update(Request $request)
    {
        $meno = MenoSetting::find(1);
        $meno->meno = $request->get('meno');
        $meno->save();
        return response()->json('successfully updated', 200);
    }

    // update footer admin
    public function footer(Request $request)
    {
        $meno = MenoSetting::find(2);
        $meno->meno = $request->get('footer');
        $meno->save();
        return response()->json('successfully updated', 200);
    }
}
