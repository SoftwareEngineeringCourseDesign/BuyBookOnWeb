<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AlterController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'nullable|integer',
            'cover' => 'nullable|string',
            'price' => 'nullable|integer',
            'stock' => 'nullable|integer',
        ]);

        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        $book = Book::where('id', $id)->first();
        if($book === null) return response(['message'=>'未找到该书籍'],404);
        if(!in_array($user->role->alias,['root','bookseller']) || $user->id !== $book->user_id)
            return response(['message'=>'您没有权限'],403);

        if($request->input('price') !== null) $book->price = $request->input('price');
        if($request->input('stock') !== null) $book->stock = $request->input('stock');
        if($request->input('cover') !== null) $book->cover = $request->input('cover');
        if($request->input('category_id') !== null) $book->category()->associate(Category::where('id', $request->input('category_id'))->first());
        $book->passed = 0;
        $book->save();
        return ;
    }
}
