<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReceiveController extends Controller
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
        if($order->step !== 3) return response(['message'=>'警告，你即将被封号'],403);
        if($user->id !== $order->user_id) return response(['message'=>'你没有权限'],403);
        $book = $order->book;
        $book->people_number++;
        $book->sum_score = $book->sum_score+10;
        $book->score = $book->sum_score/$book->people_number;
        $book->sell_number = $book->sell_number + $order->number;
        $book->save();
        $order->step = 4;
        $order->save();
        return ;
    }
}
