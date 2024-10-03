<?php
namespace App\Services;

use App\Models\News;

class NewsService
{
    public function getNewsByCategory($category_id = null)
    {
        if ($category_id) {
            return News::where('category_id', $category_id)->get();
        }
        return News::all();
    }

    public function findNewsById($id)
    {
        return News::find($id);
    }

    public function createNews(array $data)
    {
        return News::create($data);
    }

    public function updateNews($id, array $data)
    {
        $news = News::findOrFail($id);
        $news->update($data);
        return $news;
    }

    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
    }
}
