<?php

namespace App\Http\Controllers\User;

use App\Events\AdminNotfication;
use App\Events\UserNotification;
use App\Events\UserRegister;
use App\Http\Controllers\Controller;
use App\Models\Admin\Permissions;
use App\Models\Site\ActivationCodes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // check user
    public function index(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|exists:app_users|numeric',
            'api_token' => 'required|exists:app_users',
        ]);

        $user = User::where($validData)->first();
        if ($user->is_active == 1) {
            if ($user->id == $validData['id'] and $user->api_token == $validData['api_token']) {
                return response()->json([
                    'status' => 200,
                ]);
            }
        }
    }

    // login
    public function login(Request $request)
    {
        $type = null;
        if ($request->get('type') == 'email') {
            $validData = $request->validate([
                'email' => 'required|exists:app_users|string|email',
                'password' => 'required|string'
            ]);
            $type = 'email';
        } else {
            $validData = $request->validate([
                'phone' => 'required|exists:app_users|numeric',
                'password' => 'required|string'
            ]);
            $type = 'phone';
        }
        App::setLocale($request->input('lang'));
        if (!auth()->attempt($validData)) {
            return response()->json([
                'status' => 204,
                'error' => __('auth.password'),
            ]);
        } else {
            if (auth()->user()->is_active == 1) {
                auth()->login(auth()->user());
                if ($type == 'email') {
                    if (auth()->user()->email_verified == 1) {
                        return response()->json([
                            'status' => 200,
                            'data' => [
                                'id' => auth()->user()->id,
                                'role' => auth()->user()->role,
                                'token' => auth()->user()->api_token,
                            ]
                        ]);
                    } else {
                        event(new UserRegister(auth()->user(), 'email'));
                        return response()->json([
                            'status' => 203,
                        ]);
                    }
                } else {
                    if (auth()->user()->phone_verified == 1) {
                        return response()->json([
                            'status' => 200,
                            'data' => [
                                'id' => auth()->user()->id,
                                'role' => auth()->user()->role,
                                'token' => auth()->user()->api_token,
                            ]
                        ]);
                    } else {
                        event(new UserRegister(auth()->user(), 'phone'));
                        return response()->json([
                            'status' => 203,
                        ]);
                    }
                }

            } else {
                return response()->json([
                    'status' => 204,
                    'error' => __('auth.not-active'),
                ]);
            }
        }
    }

    // check code
    public function autologin(Request $request)
    {
        $step = 0;
        $validCode = $request->validate([
            'code' => 'numeric|required',
        ]);

        if ($request->get('type') == 'email') {
            $validData = $request->validate([
                'email' => 'required|exists:app_users|string|email',
            ]);
            $user = User::where($validData)->first();
            $active = ActivationCodes::where('user_id', $user->id)->first();

            if ($active->email_code == $validCode['code']) {
                $user->email_verified = 1;
                $step++;
            }

        } else if ($request->get('type') == 'phone') {
            $validData = $request->validate([
                'phone' => 'required|exists:app_users|numeric',
            ]);
            $user = User::where($validData)->first();
            $active = ActivationCodes::where('user_id', $user->id)->first();

            if ($active->phone_code == $validCode['code']) {
                $user->phone_verified = 1;
                $step++;
            }
        }

        if ($step == 0) {
            return response()->json([
                'status' => 204,
            ]);
        } else {
            $user->save();
            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $user->id,
                    'token' => $user->api_token,
                    'role' => 'user'
                ],
            ]);
        }

    }

    // send code
    public function sendcode(Request $request)
    {
        if ($request->get('type') == 'email') {
            $validData = $request->validate([
                'email' => 'required|exists:app_users|string|email',
            ]);
            $user = User::where($validData)->first();
            if ($user->is_active == 1) {
                event(new UserRegister($user, 'email'));
            }

        } else if ($request->get('type') == 'phone') {
            $validData = $request->validate([
                'phone' => 'required|exists:app_users|numeric',
            ]);
            $user = User::where($validData)->first();
            if ($user->is_active == 1) {
                event(new UserRegister($user, 'phone'));
            }
        }
        return response()->json([
            'status' => 200,
        ]);

    }

    // sign up
    public function register(Request $request)
    {
        App::setLocale($request->get('lang'));

        $validData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:app_users,email|string|email',
            'phone' => 'required|unique:app_users,phone|numeric',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $validData['name'],
            'role' => 'user',
            'is_active' => 1,
            'phone_verified' => 0,
            'email_verified' => 0,
            'phone' => $validData['phone'],
            'email' => $validData['email'],
            'setting' => json_encode($request->get('setting')),
            'password' => bcrypt($validData['password']),
            'api_token' => Str::random(100)
        ]);


        event(new UserRegister($user, 'both'));
        return response()->json([
            'status' => 200,
        ]);

    }

    // auth user
    public function authenticate(Request $request)
    {
        $validData = $request->validate([
            'email' => 'required|exists:app_users|string|email',
            'phone' => 'required|exists:app_users|numeric',
        ]);

        $user = User::where($validData)->first();
        event(new UserRegister($user, 'both'));
        return response()->json([
            'status' => 200,
        ]);

    }

    // complete login
    public function done(Request $request)
    {
        $validData = $request->validate([
            'email' => 'required|exists:app_users|string|email',
            'phone' => 'required|exists:app_users|numeric',
        ]);
        $validPhoneCode = $request->validate([
            'phonecode' => 'numeric|nullable',
        ]);
        $validEmailCode = $request->validate([
            'emailcode' => 'numeric|nullable',
        ]);
        $user = User::where($validData)->first();
        $active = ActivationCodes::where('user_id', $user->id)->first();

        $step = 0;
        if ($active->phone_code == $validPhoneCode['phonecode']) {
            $user->phone_verified = 1;
            $step++;
        }

        if ($active->email_code == $validEmailCode['emailcode']) {
            $user->email_verified = 1;
            $step++;
        }

        if ($step == 0) {
            return response()->json([
                'status' => 204,
            ]);
        } else {
            $user->save();
            event(new AdminNotfication($user->name . " ثبت نام کرد "));
            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $user->id,
                    'token' => $user->api_token,
                    'role' => 'user'
                ],
            ]);
        }

    }

    // get user info
    public function info(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|exists:app_users|numeric',
            'api_token' => 'required|exists:app_users|string',
        ]);

        $user = User::where($validData)->first();
        $operator = Permissions::where('user_id', $request->get('id'))->first();
        return response()->json([
            'status' => 200,
            'name' => $user->name,
            'step' => $user->step,
            'role' => $operator == null ? '' : json_decode($operator->access)
            ,
        ]);
    }

    // check user
    public function check(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|exists:app_users|numeric',
            'api_token' => 'required|exists:app_users',
            'password' => 'required|string'
        ]);
        if (!auth()->attempt($validData)) {
            return response()->json([
                'status' => 'failed',
            ]);
        } else {
            return response()->json([
                'status' => 'ok',
            ]);
        }
    }

    // change password
    public function change(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|exists:app_users|numeric',
            'api_token' => 'required|exists:app_users',
        ]);
        if (!$validData) {
            return response()->json([
                'status' => 'failed',
            ]);
        } else {
            $user = User::where($validData)->first();
            $user->password = bcrypt($request->get('password'));
            $user->save();
            event(new UserNotification($user, 'password', $request->get('id')));
            return response()->json([
                'status' => 'ok',
            ]);
        }
    }

}
