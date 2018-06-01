<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AlterController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $this->validate($request, [
            'password_old' => 'required|string|regex:/^[A-Za-z0-9]{40}$/',
            'password_new' => 'required|string|regex:/^[A-Za-z0-9]{40}$/',
        ]);
        $now_user = Auth::user();
        if($now_user === null) return response(['message'=>'您未登录'],401);
        $role = $now_user->role()->first();
        if($id !== $now_user->id && $role->alias !== 'root') return response(['message'=>'您没有修改该用户的权限'],403);
        $user = \App\Models\User::find($id);
        if($user === null) return response(['message'=>'该用户不存在'],404);
        if(! app('hash')->check($request->input('password_old'), $user->password)) return response(['message'=>'密码错误'],404);
        $user->password = $request->input('password_new');
        $user->save();
        return ;
    }
}
