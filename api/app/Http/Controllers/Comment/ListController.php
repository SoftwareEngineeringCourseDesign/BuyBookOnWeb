<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;


class ListController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'nullable|integer',
            'book_id' => 'nullable|integer',
        ]);
        if($request->input('user_id') !== null)
        {
            if(Auth::user()->role->alias !== 'root')
                $comments = Auth::user()->comments()->get();
            else $comments = Comment::where('user_id', $request->input('user_id'));
        }
        else if($request->input('book_id') !== null)
            $comments = Comment::where('book_id', $request->input('book_id'));
        else return response(['message'=>'请检查你的输入信息'],403);

        $response = [];
        foreach ($comments as $key=>$comment) {
            $book = $comment->book()->first();
            $user = $comment->user()->first();
            $response[] = [
                'id' => $comment->id,
                'content' => $comment->content,
                'book' => [
                    'id' => $book->id,
                    'name' => $book->name,
                ],
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                ]
            ];
        }

        return response($response);
    }
}
