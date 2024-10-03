<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        try {
            $category_id = $request->query('category_id');
            $news = $this->newsService->getNewsByCategory($category_id);
            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error fetching news: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch news'], 500);
        }
    }

    public function show($id)
    {
        try {
            $news = $this->newsService->findNewsById($id);

            if (!$news) {
                return response()->json(['error' => 'News not found'], 404);
            }

            $category = $news->category;
            $news['category_name'] = $category->name;

            return response()->json($news);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function store(NewsRequest $request, $category_id)
    {
        $validatedData = $request->validated();
        $validatedData['category_id'] = $category_id;

        try {
            $news = $this->newsService->createNews($validatedData);
            return response()->json($news, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create news'], 500);
        }
    }

    public function update(NewsRequest $request, $id)
    {
        $validatedData = $request->validated();

        try {
            $news = $this->newsService->updateNews($id, $validatedData);
            return response()->json($news, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update news'], 500);
        }
    }

    public function deleteNews($id)
    {
        try {
            $this->newsService->deleteNews($id);
            return response()->json(['message' => 'Новина успішно видалена!'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting news: ' . $e->getMessage());
            return response()->json(['error' => 'Не вдалося видалити новину'], 500);
        }
    }
}
