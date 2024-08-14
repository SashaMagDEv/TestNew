<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

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

        if (!is_numeric($id)) {
            return response()->json(['message' => 'Invalid category ID'], 400);
        }

        $newsQuery = News::where('category_id', $id);

        $totalNews = $newsQuery->count();

        $news = $newsQuery->paginate($perPage, ['*'], 'page', $page);

        $baseUrl = $request->url();
        $queryParams = $request->query();
        unset($queryParams['page']);

        $queryString = http_build_query($queryParams);

        $linkToPage = fn($page) => $queryString ? "{$baseUrl}?{$queryString}&page={$page}" : "{$baseUrl}?page={$page}";

        return response()->json([
            'data' => $news->items(),
            'meta' => [
                'total_news' => $totalNews,
                'current_page' => $news->currentPage(),
                'total_pages' => $news->lastPage(),
                'link_to_first_page' => $linkToPage(1),
                'link_to_last_page' => $linkToPage($news->lastPage()),
                'link_to_previous_page' => $news->previousPageUrl(),
                'link_to_next_page' => $news->nextPageUrl()
            ]
        ]);
    }



}
