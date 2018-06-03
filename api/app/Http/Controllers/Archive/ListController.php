<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use App\Models\ArchiveBook;
use App\Models\ArchiveSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ListController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request, $type)
    {
        $this->validate($request, [
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer',
        ]);
        $user = Auth::user();
        if($user === null) return response(['message'=>'您未登录'],401);
        if($type === 'seller') $archives = ArchiveSeller::where('id', '>', 0);
        else if($type === 'book') $archives = ArchiveBook::where('id', '>', 0);
        else return response(['message'=>'备案分类有误'],404);
        if($user->role->alias !== 'root') $archives = $archives->where('user_id', $user->id);
        $number = count($archives->get());
        $archives = $archives->take($request->input('limit', $number));
        $archives = $archives->offset($request->input('offset', 0));
        $archives = $archives->latest()->get();
        $response = [];

        if($type === 'seller') {
            foreach ($archives as $key => $archive) {
                $user = $archive->user()->first();
                $response[] = [
                    'id' => $archive->id,
                    'created_at' => $archive->created_at->timestamp??0,
                    'updated_at' => $archive->updated_at->timestamp??$archive->created_at->timestamp??0,
                    'passed' => $archive->passed,
                    'user' => ($user === null) ? null : [
                        'id' => $user->id,
                        'name' => $user->username,
                    ],
                ];
            }
        }
        else if($type === 'book') {
            foreach ($archives as $key => $archive) {
                $book = $archive->book()->first();
                $response[] = [
                    'id' => $archive->id,
                    'created_at' => $archive->created_at->timestamp??0,
                    'updated_at' => $archive->updated_at->timestamp??$archive->created_at->timestamp??0,
                    'passed' => $archive->passed,
                    'book' => ($book === null) ? null : [
                        'id' => $book->id,
                        'name' => $book->name,
                    ],
                ];
            }
        }

        return response($response)->header('X-Total', $number);
    }
}
