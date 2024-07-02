<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $perPage = 10;

        $news = News::where('category_id', $categoryId)
            ->paginate($perPage);

        return response()->json($news);
    }
}
