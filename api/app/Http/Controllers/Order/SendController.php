<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SendController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        $order = Order::where('id', $id)->first();
        if($order === null) return response(['message'=>'订单不存在'],404);
        if($order->step !== 2) return response(['message'=>'你tm别乱操作了行嘛'],403);
        $book = $order->book;
        if($book->user->id !== $user->id)
            return response(['message'=>'你没有权限'],403);
        if($book->stock-$order->number<0) return response(['message'=>'库存不足'],402);
        $book->stock = $book->stock - $order->number;
        $book->save();
        $order->step = 3;
        $order->save();
        return ;
    }
}
