<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NewController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $this->validate($request, [
           'content' => 'required|string',
        ]);
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        $order = Order::where('id', $id)->first();
        if($order === null) return response(['message'=>'订单不存在'],404);
        if($order->user_id !== $user->id)
            return response(['message'=>'你没有权限'],403);
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user()->associate($user);
        $comment->book()->associate($order->book);
        $comment->save();
        return response([
            'id' => $comment->id,
        ]);
    }
}
