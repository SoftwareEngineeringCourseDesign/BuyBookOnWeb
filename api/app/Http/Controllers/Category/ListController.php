<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class ListController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request)
    {
        $categories = Category::all();
        $response = [];
        foreach($categories as $key=>$category){
            $response[$key] = [
                'id' => $category->id,
                'name' => $category->name,
            ];
        }
        return response($response);
    }
}
