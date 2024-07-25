<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function getNewsByCategory($id)
    {
        try {
            $category = Category::with(['news' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->findOrFail($id);

            return response()->json([
                'category' => $category,
                'news' => $category->news()->paginate(5),
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching news by category: ' . $e->getMessage());
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    public function storeNews(Request $request, $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $validatedData = $request->validated();
            $validatedData['category_id'] = $category->id;

            $news = News::create($validatedData);

            return response()->json($news, 201);
        } catch (\Exception $e) {
            Log::error('Error creating news: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create news'], 500);
        }
    }
}
