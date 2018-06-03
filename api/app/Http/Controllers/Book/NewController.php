<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
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
            'name' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'category_id' => 'required|integer',
            'cover' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        if($user->role->alias !== 'bookseller')
            return response(['message'=>'您没有权限'],403);

        $book = Book::create();
        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->price = $request->input('price');
        $book->stock = $request->input('stock');
        $book->cover = $request->input('cover');
        $book->category()->associate(Category::where('id', $request->input('category_id'))->first());
        $book->user()->associate($user);
        $book->save();
        return response([
            'id' => $book->id,
        ]);
    }
}
