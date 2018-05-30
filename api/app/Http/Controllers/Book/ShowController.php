<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;


class ShowController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request)
    {
        $this->validate($request,[
            'category_id' => 'nullable|integer',
            'keyword' => 'nullable|string',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);

        $books = Book::where('passed', 1);

        if($request->input('category_id') !== null)
            $books = $books->where('category_id', $request->input('category_id'));
        if($request->input('keyword') !== null){
            $keyword = $request->input('keyword');
            $books= $books->where(function ($query) use ($keyword){
                $query->where('name','like','%'.$keyword.'%')
                    ->orWhere('author','like','%'.$keyword.'%')
                    ->orWhere('publisher','like','%'.$keyword.'%');
            });
        }
        if($request->input('min_price') !== null)
            $books = $books->where('price', '>=', $request->input('min_price'));
        if($request->input('max_price') !== null)
            $books = $books->where('price', '<=', $request->input('max_price'));

        $number = count($books->get());
        $books = $books->take($request->input('limit',$number));
        $books = $books->offset($request->input('offset',0));
        $books = $books->latest()->get();
        $response = [];
        foreach ($books as $key=>$book) {
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
        }
        return response($response)->header('X-Total', $number);
    }
}
