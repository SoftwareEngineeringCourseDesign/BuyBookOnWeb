<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PayController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        if($order === null) return response(['message'=>'订单不存在'],404);
        if($order->step !== 1) return response(['message'=>'订单已支付'],402);
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        if($user->id !== $order->user_id) return response(['message'=>'您没有权限'],403);
        if($user->money * 100 - $order->price < 0) return response(['message'=>'您余额不足'],403);
        $user->money = $user->money - $order->price / 100.0;
        $user->save();
        $order->step = 2;
        $order->save();
        return ;
    }
}
