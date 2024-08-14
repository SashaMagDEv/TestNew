<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Помилка на сервері'], 500);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Категорія не знайдена'], 404);
        }
        return response()->json($category);
    }

    public function getNewsByCategory($id, Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = 10;

        $newsQuery = News::where('category_id', $id);
        $total = $newsQuery->count();
        $news = $newsQuery->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $news->items(),
            'meta' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total()
            ]
        ]);
    }

}
