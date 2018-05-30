<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;


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
            'cover' => 'nullable|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        $book = new Book();
        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->price = $request->input('price');
        $book->stock = $request->input('stock');
        $book->cover = $request->input('cover');
        $book->category()->associate(Category::where('id', $request->input('category_id'))->first());
        $book->user()->associate(Auth::user());
        $book->score = 0;
        $book->number = 0;
        $book->passed = 0;
        $book->save();
        return response([
            'id' => $book->id,
        ]);
    }
}
