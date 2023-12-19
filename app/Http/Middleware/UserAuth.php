<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class UserAuth
{
    // for check user
    public function handle(Request $request, Closure $next)
    {
        $validData = $request->validate([
            'api_token' => 'required|exists:app_users|size:100'
        ]);
        if ($validData) {
            return $next($request);
        }
    }
}
