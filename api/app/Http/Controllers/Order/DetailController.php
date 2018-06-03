<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DetailController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $user = Auth::user();
        if($user === null)return response(['message'=>'您未登录'],401);
        $order = Order::where('id', $id)->first();
        if($order === null) return response(['message'=>'该订单不存在'],404);
        if($user->role->alias !== 'root' && $user->id !== $order->user_id && $user->id !== $order->book->user_id)
            return response(['message'=>'您没有权限'],403);
        $book = $order->book;
        $user = $order->user;
        $response = [
            'id' => $order->id,
            'number' => $order->number,
            'price' => $order->price,
            'step' => $order->step,
            'book' => [
                'id' => $book->id,
                'name' => $book->name,
            ],
            'user' => [
                'id' => $user->id,
                'name' => $user->username,
            ],
            'created_at' => $order->created_at->timestamp??0,
            'updated_at' => $order->updated_at->timestamp??$order->created_at->timestamp??0,
        ];
        return response($response);
    }
}
