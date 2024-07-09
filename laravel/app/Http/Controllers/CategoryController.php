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
        $category = Category::findOrFail($id); // Знайдемо категорію за ID
        return response()->json($category); // Повернемо її у форматі JSON
    }

    public function getNewsByCategory($id)
    {
        $category = Category::with(['news' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'category' => $category,
            'news' => $category->news()->paginate(5),
        ]);
    }

    public function storeNews(Request $request, $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'thumbnail' => 'required|string|max:255',
                'short_description' => 'required|string',
                'date' => 'required|date',
                'likes' => 'required|integer',
            ]);
            $validatedData['category_id'] = $category->id;

            $news = News::create($validatedData);

            return response()->json($news, 201);
        } catch (\Exception $e) {
            Log::error('Error creating news: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create news'], 500);
        }
    }
}
