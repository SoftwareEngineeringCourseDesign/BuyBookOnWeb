<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;


class ShowDetailController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $book = Book::where('id', $id)->first();
        if($book === null) return response(['message'=>'未找到该书籍'],404);
        $user = $book->user;
        $category = $book->category;
        $response[] =[
            'id' => $book->id,
            'name' => $book->name,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'price' => $book->price,
            'score' => $book->score,
            'sell_number' => $book->sell_number,
            'people_number' => $book->people_number,
            'cover' => $book->cover,
            'passed' => $book->passed,
            'user' => ($user === null) ? null : [
                'id' => $user->id,
                'name' => $user->username,
            ],
            'category' => ($category === null) ? null : [
                'id' => $category->id,
                'name' => $category->name,
            ],
            'created_at' => $book->created_at->timestamp??0,
            'updated_at' => $book->updated_at->timestamp??$book->created_at->timestamp??0,
        ];
        return response($response);
    }
}
