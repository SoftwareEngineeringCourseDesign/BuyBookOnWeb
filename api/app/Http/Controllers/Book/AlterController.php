<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;


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

        $book = Book::where('id', $id)->first();
        if($book === null||!$book->passed) return response(['message'=>'未找到该书籍'],404);
        if($request->input('price') !== null) $book->price = $request->input('price');
        if($request->input('stock') !== null) $book->stock = $request->input('stock');
        if($request->input('cover') !== null) $book->cover = $request->input('cover');
        if($request->input('category_id') !== null) $book->category()->associate(Category::where('id', $request->input('category_id'))->first());
        $book->passed = 0;
        $book->save();
        return response([
            'id' => $book->id,
        ]);
    }
}
