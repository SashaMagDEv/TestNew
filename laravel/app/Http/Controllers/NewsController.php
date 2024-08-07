<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function show($id)
    {
        try {
            $news = News::find($id);

            if (!$news) {
                return response()->json(['error' => 'News not found'], 404);
            }

            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error fetching news:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $news = News::create($validatedData);

        return response()->json($news, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $news = News::find($id);

            if (!$news) {
                return response()->json(['error' => 'News not found'], 404);
            }

            $news->title = $request->input('title');
            $news->thumbnail = $request->input('thumbnail');
            $news->short_description = $request->input('short_description');
            $news->date = $request->input('date');
            $news->likes = $request->input('likes');
            $news->save();

            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error updating news:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
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

}
