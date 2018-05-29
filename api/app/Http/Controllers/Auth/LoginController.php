<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Ramsey\Uuid\uuid;

class LoginController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request)
    {
        $user = User::where('username', $request->input('username'))->
            orWhere('email', $request->input('username'))->first();
        if ($user === null) return response(['message'=>'用户名和密码有误'],404);
        if (!app('hash')->check($request->input('password'), $user->password)) return response(['message'=>'用户名和密码有误'],401);
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
