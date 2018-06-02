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
        $order->step = 2;
        $order->save();
        return ;
    }
}
