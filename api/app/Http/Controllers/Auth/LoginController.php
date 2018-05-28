<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Models\User;
use http\Env\Request;

class LoginController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();
        if ($user === null) return response(['message'=>'用户名和密码有误'],403);
        if (!app('hash')->check($request->input('password'), $user->password)) return response(['message'=>'用户名和密码有误'],403);
        $apiToken = new ApiToken();
        $apiToken->token = Uuid::uuid4()->toString();
        $apiToken->ip = $request->server('HTTP_X_FORWARDED_FOR', $request->server('REMOTE_ADDR', null));
        $apiToken->expired_at = Carbon::now()->addMinutes(30);
        $user->tokens()->save($apiToken);
        return response([
            'token' => $apiToken->token,
            'user_id' => $user->id,
        ]);
    }
}
