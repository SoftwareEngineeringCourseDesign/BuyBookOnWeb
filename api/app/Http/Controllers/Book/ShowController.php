<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
            'order' => 'nullable|string',
            'direction' => 'nullable|string',
            'user_id' => 'nullable|string',
            'passed' => 'nullable|integer',
        ]);
        if($request->input('user_id') !== null) {
            if(Auth::user()->role->alias !== 'root' && Auth::user()->id !== $request->input('user_id'))
                $books = Book::where('user_id', $request->input('user_id'))->where('passed', 1)->latest();
            else {
                $books = Book::where('user_id', $request->input('user_id'))->latest();
                if ($request->input('passed', null) !== null) $books = $books->where('passed', +$request->input('passed'));
                if ($request->input('category_id', null) !== null) $books = $books->where('category_id', +$request->input('category_id'));
            }
        }
        else {
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

            if($request->input('order') === 'random') {
                $books = $books->inRandomOrder();
            }
            else if($request->input('order') === 'price') {
                $books = $books->orderBy('price', $request->input('direction','asc'));
            }
            else if($request->input('order') === 'volume') {
                $books = $books->orderBy('sell_number', $request->input('direction','asc'));
            }
            else if($request->input('order') === 'score') {
                $books = $books->orderBy('score', $request->input('direction','asc'));
            }
            else $books = $books->latest();
        }

        $number = count($books->get());
        $books = $books->take($request->input('limit',$number));
        $books = $books->offset($request->input('offset',0));
        $books = $books->get();

        $response = [];
        foreach ($books as $key=>$book) {
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
                'passed' => $book->passed,
            ];
        }
        return response($response)->header('X-Total', $number);
    }
}
