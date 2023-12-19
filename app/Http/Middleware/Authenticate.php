<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class Authenticate
{
    // for check admin
    public function handle(Request $request, Closure $next)
    {
        $validData = $request->validate([
            'api_token' => 'required|exists:app_users|size:100'
        ]);
        if ($validData) {
            $user = User::where($validData)->first();
            if ($user->role == 'user') {
                return response()->json('unauthenticated', 401);
            }
            $request->attributes->add(['user' => $user->role]);
            return $next($request);
        }
    }
}
