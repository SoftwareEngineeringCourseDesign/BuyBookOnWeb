<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;


class NewController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $id)
    {
        $this->validate($request,[
           'content' => 'require|string',
        ]);
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user()->associate($user);
        $comment->book()->associate(Book::where('id', $id));
        $comment->save();
        return response([
            'id' => $comment->id,
        ]);
    }
}
