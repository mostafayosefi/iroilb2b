<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Site\Company;
use App\Models\Site\UserNotification as UserModel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UserNotification as UserNotificate;

class UserNotification extends Controller
{
    // show admin all notification
    public function index()
    {
        $notification = UserModel::orderByDesc('id')->get();
        $data = [];
        $i = 0;
        foreach ($notification as $notificate) {
            $data[$i]['id'] = $notificate['id'];
            $user = User::find($notificate['user_id_sender']);
            $data[$i]['sender'] = $user->name;
            $user = User::find($notificate['user_id_receiver']);
            $data[$i]['receiver'] = $user->name;
            $data[$i]['status'] = $notificate['status'] == 'unread' ? 'خوانده نشده' : 'خوانده شده';
            $data[$i]['message'] = $notificate['message'];
            $data[$i]['time'] = jdate($notificate['updated_at'])->format('H:i Y/m/d');
            $i++;
        }
        return response()->json($data, 200);

    }

    // user send message to other company
    public function company(Request $request)
    {
        $company = Company::find($request->get('company'));
        foreach (json_decode($company->users_management) as $users) {
            $user = User::find($users);
            $notification = new UserModel([
                'user_id_receiver' => $user->id,
                'user_id_sender' => $request->get('id'),
                'status' => 'unread',
                'message' => $request->get('message')
            ]);
            $notification->save();
            event(new UserNotificate($user, 'send', $request->get('id')));
        }
        return response()->json('success', 200);
    }

    // send admin single user notification
    public function single(Request $request)
    {
        $notification = new UserModel([
            'user_id_receiver' => $request->get('receiver'),
            'user_id_sender' => $request->get('sender'),
            'status' => 'unread',
            'message' => $request->get('message')
        ]);
        $notification->save();
        $user = User::find($request->get('receiver'));
        event(new UserNotificate($user, 'send', $request->get('receiver')));
        return response()->json('success', 200);
    }

    // send admin notification multi users
    public function multi(Request $request)
    {
        $lists = Company::all();
        foreach ($lists as $item) {
            $body = json_decode($item['data']);
            if ($body->tag) {
                foreach ($body->tag as $tag) {
                    if ($request->get('tag') == $tag) {
                        $users = json_decode($item['users_management']);
                        foreach ($users as $user) {
                            $notification = new UserModel([
                                'user_id_receiver' => $user,
                                'user_id_sender' => $request->get('sender'),
                                'status' => 'unread',
                                'message' => $request->get('message')
                            ]);
                            $notification->save();
                            $reciver = User::find($user);
                            event(new UserNotificate($reciver, 'send', $user));
                        }
                    }
                }
            }
        }
        return response()->json('success', 200);
    }

    // set user notification setting
    public function setting(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|exists:app_users|numeric',
            'api_token' => 'required|exists:app_users',
        ]);

        $user = User::where($validData)->first();
        $user->setting = json_encode($request->get('setting'));
        $user->save();
        return response()->json('success', 200);
    }

    // get user notification
    public function get(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|exists:app_users|numeric',
            'api_token' => 'required|exists:app_users',
        ]);
        $user = User::where($validData)->first();
        return response()->json(json_decode($user->setting), 200);
    }

    //get user notification
    public function user(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|exists:app_users|numeric',
            'api_token' => 'required|exists:app_users',
        ]);
        if (!$validData) {
            return response()->json([
                'status' => 'failed',
                'notificate' => null
            ]);
        } else {
            $notification = UserModel::where('user_id_receiver', $request->get('id'))->orderByDesc('id')->get();
            $data = [];
            $i = 0;
            foreach ($notification as $notificate) {
                $data[$i]['id'] = $notificate['id'];
                $user = User::find($notificate['user_id_sender']);
                $data[$i]['sender'] = $user->name;
                $user = User::find($notificate['user_id_receiver']);
                $data[$i]['receiver'] = $user->name;
                $data[$i]['status'] = $notificate['status'];
                $data[$i]['message'] = $notificate['message'];
                $data[$i]['time'] = $request->get('language') == 'fa' ? jdate($notificate['updated_at'])->format('H:i Y/m/d') : $notificate['updated_at']->format('Y/m/d H:i');
                $i++;
            }
            return response()->json([
                'status' => 'ok',
                'notificate' => $data
            ]);
        }
    }

}

