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
        if($book === null||!$book->passed) return response(['message'=>'未找到该书籍'],404);
        $user = $book->user()->first();
        $response[] =[
            'id' => $book->id,
            'name' => $book->name,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'price' => $book->price,
            'score' => $book->score,
            'number' => $book->number,
            'cover' => $book->cover,
            'user' => ($user === null) ? null : [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'created_at' => $book->created_at->timestamp??0,
            'updated_at' => $book->updated_at->timestamp??$book->created_at->timestamp??0,
        ];
        return response($response);
    }
}
