<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);
        if($request->input('user_id') !== null)
        {
            $user = Auth::user();
            if($user === null) return response(['message'=>'您未登录'],401);
            if($user->role->alias !== 'root')
                $comments = $user->comments();
            else $comments = Comment::where('user_id', $request->input('user_id'));
        }
        else if($request->input('book_id') !== null)
            $comments = Comment::where('book_id', $request->input('book_id'));
        else return response(['message'=>'请检查你的输入信息'],403);

        $number = count($comments->get());
        $comments = $comments->take($request->input('limit', $number));
        $comments = $comments->offset($request->input('offset', 0));
        $comments = $comments->latest()->get();
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
                ],
                'created_at' => $comment->created_at->timestamp,
            ];
        }

        return response($response)->header('X-Total', $number);
    }
}
