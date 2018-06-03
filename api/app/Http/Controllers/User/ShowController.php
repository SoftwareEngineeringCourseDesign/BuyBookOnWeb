<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ShowController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $now_user = Auth::user();
        if ($now_user === null) return response(['message' => '您未登录'], 401);
        $now_role = $now_user->role()->first();
        if ($now_user->id !== +$id  && $now_role->alias !== 'root')
            return response(['message' => '您没有查询该用户的权限'], 403);
        $user = \App\Models\User::find($id);
        if ($user === null) return response(['message' => '该用户不存在'], 404);
        $role = $user->role()->first();
        return response([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $role === null ? null : [
                'id' => $role->id,
                'name' => $role->name,
                'alias' => $role->alias,
            ],
            'created_at' => $user->created_at->timestamp,
        ]);
    }
}
