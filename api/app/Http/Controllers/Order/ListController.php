<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ListController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'nullable|integer',
            'book_id' => 'nullable|integer',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);

        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        if($request->input('user_id') !== null)
        {
            if($user->role->alias !== 'root')
                $orders = $user->orders();
            else $orders = Order::where('user_id', $request->input('user_id'));
        }
        else if($request->input('book_id') !== null) {
            if($user->role->alias === 'root' || $user->id === Book::where('id', $request->input('book_id'))->first()->user_id)
                $orders = Order::where('book_id', $request->input('book_id'));
            else return response(['message'=>'你没有权限'],403);
        }
        else return response(['message'=>'请检查你的输入信息'],403);

        $number = count($orders->get());
        $orders = $orders->take($request->input('limit', $number));
        $orders = $orders->offset($request->input('offset', 0));
        $orders = $orders->latest()->get();
        $response = [];
        foreach ($orders as $key=>$order) {
            $book = $order->book;
            $user = $order->user;
            $response[] = [
                'id' => $order->id,
                'step' => $order->step,
                'book' => [
                    'id' => $book->id,
                    'name' => $book->name,
                ],
                'user' => [
                    'id' => $user->id,
                    'name' => $user->username,
                ],
                'created_at' => $order->created_at->timestamp,
            ];
        }

        return response($response)->header('X-Total', $number);
    }
}
