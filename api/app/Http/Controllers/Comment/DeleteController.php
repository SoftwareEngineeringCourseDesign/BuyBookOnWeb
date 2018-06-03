<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeleteController extends Controller
{

    public function __construct()
    {
        //
    }


    public function handle(Request $request, $id) {
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        $comment = Comment::where('id', '=', $id)->first();
        if($comment === null) return response(['message'=>'该评论不存在'],404);
        if($user->id !== $comment->user_id && $user->role->alias !== 'root') return response(['message'=>'您没有删除该文章的权限'],403);
        $comment->delete();
        return ;
    }
}
