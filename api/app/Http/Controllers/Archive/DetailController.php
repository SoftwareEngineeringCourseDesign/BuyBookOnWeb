<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DetailController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $type, $id)
    {
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        if($type === 'seller') $archive = ArchiveSeller::where('id', $id);
        else if($type === 'book') $archive = ArchiveBook::where('id', $id);
        else return response(['message'=>'备案分类有误'],404);
        if($archive === null) return response(['message'=>'该备案不存在'],404);

        if($type === 'seller') {
            $user = $archive->user;
            if ($user->id !== $user->id && $user->role->alias !== 'root')
                return response(['message' => '您没有权限'], 403);
            $response = [
                'id' => $archive->id,
                'created_at' => $archive->created_at->timestamp??0,
                'updated_at' => $archive->updated_at->timestamp??$archive->created_at->timestamp??0,
                'passed' => $archive->passed,
                'attachments' => $archive->attachments,
                'user' => ($user === null) ? null : [
                    'id' => $user->id,
                    'name' => $user->username,
                ],
            ];
        }
        else if($type === 'book') {
            $book = $archive->book;
            $user = $book->user;
            $category = $book->category;
            if ($user->id !== $user->id && $user->role->alias !== 'root')
                return response(['message' => '您没有权限'], 403);
            $response = [
                'id' => $archive->id,
                'created_at' => $archive->created_at->timestamp??0,
                'updated_at' => $archive->updated_at->timestamp??$archive->created_at->timestamp??0,
                'passed' => $archive->passed,
                'attachments' => $archive->attachments,
                'book' => ($book === null) ? null : [
                    'id' => $book->id,
                    'name' => $book->name,
                    'author' => $book->author,
                    'publisher' => $book->publisher,
                    'stock' => $book->stock,
                    'cover' => $book->cover,
                    'category' => ($category === null) ? null : [
                        'id' => $category->id,
                        'name' => $category->name,
                    ],
                ],
                'user' => ($user === null) ? null : [
                    'id' => $user->id,
                    'name' => $user->username,
                ],
            ];
        }

        return response($response);
    }
}
