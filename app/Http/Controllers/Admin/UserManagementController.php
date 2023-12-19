<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permissions;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // get all user
    public function index()
    {
        $users = User::all()->except(1);
        if ($users->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $i = 0;
            foreach ($users as $user) {
                $data[$i]['id'] = $user->id;
                $data[$i]['name'] = $user->name;
                $data[$i]['active'] = $user->is_active;
                $data[$i]['email'] = $user->email;
                $data[$i]['phone'] = $user->phone;
                $data[$i]['role'] = $user->role;
                $data[$i]['step'] = $user->step;
                $data[$i]['time'] = jdate($user->created_at)->format('H:i Y/m/d');
                $i++;
            }
            return response()->json(['data' => $data], 200);
        }
    }

    // update user by admin
    public function update(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->is_active = $request->get('active');
        $user->role = $request->get('role');
        if ($request->get('role') == 'admin') {
            $operator = Permissions::where('user_id', $request->get('id'))->first();
            if ($operator == null) {
                $query = new Permissions([
                    'user_id' => $request->get('id'),
                    'access' => '{"dashboard":{"show":false},"post":{"show":false,"add":false,"edit":false,"delete":false},"category":{"show":false,"add":false,"edit":false,"delete":false},"label":{"show":false,"add":false,"edit":false,"delete":false},"page":{"show":false,"add":false,"edit":false,"delete":false},"operator":{"show":false},"table":{"show":false,"add":false,"edit":false,"delete":false},"forms":{"show":false,"delete":false},"settings":{"site":false,"header":false,"sidebar":false,"footer":false},"redirect":{"show":false,"add":false,"delete":false},"users":{"show":false,"add":false,"edit":false,"delete":false},"notificate":{"show":false,"add":false,"edit":false,"delete":false},"product":{"show":false,"add":false,"edit":false,"delete":false},"tag":{"show":false,"add":false,"edit":false,"delete":false},"company":{"show":false,"edit":false},"ads":{"show":false,"edit":false,"delete":false},"support":{"show":false,"edit":false}}',
                ]);
                $query->save();
            }
        } else {
            $operator = Permissions::where('user_id', $request->get('id'))->first();
            if ($operator) {
                $operator->delete();
            }
        }
        $user->save();
        return response()->json('successfully updated', 200);
    }
}
