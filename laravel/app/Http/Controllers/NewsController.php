<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function index()
    {
        try {
            $news = News::all();
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

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $news->title = $request->input('title');
        $news->thumbnail = $request->input('thumbnail');
        $news->date = $request->input('date');
        $news->likes = $request->input('likes');
        $news->short_description = $request->input('short_description');

        $news->save();

        return response()->json(['message' => 'Новина успішно оновлена!'], 200);
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        try {
            $news->delete();
            return response()->json(['message' => 'News deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete news'], 500);
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
//    public function getNewsByCategory($categoryId, $page = 1)
//    {
//        try {
//            Log::info('Fetching news by category', ['category_id' => $categoryId, 'page' => $page]);
//
//            $news = News::where('category_id', $categoryId)
//                ->paginate(10, ['*'], 'page', $page);
//
//            Log::info('Pagination details', [
//                'current_page' => $news->currentPage(),
//                'total_pages' => $news->lastPage(),
//                'total_items' => $news->total(),
//            ]);
//
//            return response()->json($news);
//        } catch (\Exception $e) {
//            Log::error('Error fetching news', ['exception' => $e->getMessage()]);
//            return response()->json(['error' => 'Failed to fetch news'], 500);
//        }
//    }
}
