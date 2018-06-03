<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use App\Models\ArchiveBook;
use App\Models\ArchiveSeller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuditController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $type, $id)
    {
        $this->validate($request, [
            'passed' => 'required|boolean',
        ]);
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        if($user->role->alias !== 'root') return response(['message'=>'您没有权限'],403);
        if($type === 'seller') $archive = ArchiveSeller::where('id', $id)->first();
        else if($type === 'book') $archive = ArchiveBook::where('id', $id)->first();
        else return response(['message'=>'备案分类有误'],404);
        if($archive === null) return response(['message'=>'该备案不存在'],404);

        if($type === 'seller') {
            $passed = $request->input('passed');
            if ($passed === true || $passed === 1 || $passed === 'true' || $passed === '1') $archive->passed = 1;
            else $archive->passed = 0;
            $user = $archive->user;
            $user->role()->associate(Role::where('alias', 'bookseller')->first());
            $user->save();
        }
        if($type === 'book') {
            $passed = $request->input('passed');
            $book = $archive->book;
            if ($passed === true || $passed === 1 || $passed === 'true' || $passed === '1') {
                $archive->passed = 1;
                $book->passed = 1;
            }
            else {
                $archive->passed = 0;
                $book->passed = 0;
            }
            $archive->save();
            $book->save();
        }
        return;
    }
}
