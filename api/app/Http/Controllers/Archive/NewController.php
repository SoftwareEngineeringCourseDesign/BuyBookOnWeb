<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use App\Models\ArchiveBook;
use App\Models\ArchiveSeller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NewController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $type, $id)
    {
        $this->validate($request, [
            'attachments' => 'required|string',
        ]);
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        if($type === 'seller') {
            $archive = new ArchiveSeller();
            $archive->attachments = $request->input('attachments');
            $archive->passed = 0;
            $archive->user()->associate($user);
            $archive->save();
        }
        else if($type === 'book') {
            $book = Book::where('id', $id)->first();
            if($user->id !== $book->user->id) return response(['message'=>'您没有权限'],403);
            $archive = new ArchiveBook();
            $archive->attachments = $request->input('attachments');
            $archive->passed = 0;
            $archive->book()->associate($book);
            $archive->user()->associate($user);
            $archive->save();
        }
        return response([
            'id' => $archive->id,
        ]);
    }
}
