<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Advertise;
use App\Models\Admin\Post;
use App\Models\Site\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;


class AdminController extends Controller
{
    // admin view
    public function index(Request $request)
    {
        return view('admin/app');
    }

    // admin dashboard
    public function admin()
    {
        $post = Post::all();
        $company = Company::all();
        $user = User::all();
        $ad = Advertise::all();
        return response()->json([
            'count' => [
                'posts' => $post->count(),
                'companies' => $company->count(),
                'users' => $user->count(),
                'ads' => $ad->count(),
            ],

        ], 200);
    }

}
