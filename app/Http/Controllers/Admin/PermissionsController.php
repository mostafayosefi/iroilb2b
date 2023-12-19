<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permissions;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    // get all operator
    public function index()
    {
        $users = User::where('role', 'admin')->get()->except(1);
        if ($users->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $i = 0;
            foreach ($users as $user) {
                $data[$i]['id'] = $user->id;
                $data[$i]['name'] = $user->name;
                $i++;
            }
            return response()->json(['data' => $data], 200);
        }
    }

    // get user permissions admin
    public function user($id)
    {
        $operator = Permissions::where('user_id', $id)->first();
        $data = json_decode($operator->access);
        return response()->json($data, 200);
    }

    // update user permission admin
    public function update(Request $request)
    {
        $operator = Permissions::where('user_id', $request->get('id'))->first();
        $operator->access = json_encode($request->get('role'));
        $operator->save();
        return response()->json('successfully updated', 200);
    }
}
