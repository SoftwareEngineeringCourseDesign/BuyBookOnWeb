<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EvaluateController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $this->validate($request, [
            'score' => 'required|integer',
        ]);
        $user = Auth::user();
        if ($user === null) return response(['message' => '您未登录'], 401);
        $order = Order::where('id', $id)->first();
        if ($order === null) return response(['message' => '订单不存在'], 404);
        if ($user->id !== $order->user_id) return response(['message' => '你没有权限'], 403);
        $book = $order->book;
        $book->sum_score = $book->sum_score - 5 + $request->input('score');
        $book->score = $book->sum_score / $book->people_number;
        $book->save();
        return;
    }
}
