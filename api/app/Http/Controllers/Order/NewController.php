<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NewController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|integer',
            'price' => 'required|integer',
            'book_id' => 'required|integer',
        ]);
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        $book = Book::where('id', $request->input('book_id'))->first();
        if($book === null) return response(['message'=>'该书籍不存在'],404);
        if($book->price*$request->input('number') !== $request->input('price'))
            return response(['message'=>'订单不合法'],403);

        $order = new Order();
        $order->number = $request->input('number');
        $order->price = $request->input('price');
        $order->book()->associate($book);
        $order->user()->associate($user);
        $order->step = 1;
        $order->save();
        return response([
            'id' => $order->id,
        ]);
    }
}
