<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    // get all redirects admin
    public function index()
    {
        $redirect = Redirect::all();
        if ($redirect->count() == 0) {
            return response()->json('null', 200);
        } else {
            return response()->json(['data' => $redirect], 200);
        }
    }

    // store redirect admin
    public function store(Request $request)
    {
        $redirect = new Redirect([
            'link' => $request->get('link'),
            'redirect' => $request->get('to'),
            'status' => $request->get('code')
        ]);
        $redirect->save();
        return response()->json('success', 200);
    }

    // delete admin redirect
    public function delete($id)
    {
        $redirect = Redirect::find($id);
        $redirect->delete();
        return response()->json('successfully deleted', 200);
    }
}
