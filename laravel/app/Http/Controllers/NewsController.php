<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function index($category_id)
    {
        try {
            $news = News::where('category_id', $category_id)->get();
            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error fetching news: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch news'], 500);
        }
    }

    public function show($id)
    {
        try {
            $news = News::find($id);

            if (!$news) {
                return response()->json(['error' => 'News not found'], 404);
            }

            return response()->json($news);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function update(NewsRequest $request, $id)
    {
        $validatedData = $request->validated();
        try {
            $news = News::findOrFail($id);
            $news->update($validatedData);
            return response()->json($news, 200);
        } catch (\Exception $e) {
            // Повернути помилку у разі винятку
            return response()->json(['message' => 'Failed to update news'], 500);
        }
    }

    public function store(NewsRequest $request, $category_id)
    {
        $validatedData = $request->validated();
        $validatedData['category_id'] = $category_id;
        try {
            $news = News::create($validatedData);
            return response()->json($news, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create news'], 500);
        }
    }

    public function deleteNews($id)
    {
        try {
            $news = News::findOrFail($id);

            $news->delete();

            return response()->json(['message' => 'Новина успішно видалена!'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting news: ' . $e->getMessage());
            return response()->json(['error' => 'Не вдалося видалити новину'], 500);
        }
    }
}
