<?php

namespace App\Services;

use App\Models\Category;
use App\Models\News;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function getCategoryById($id)
    {
        return Category::find($id);
    }

    public function getNewsByCategoryId($id)
    {
        return News::where('category_id', $id)->paginate(10);
    }
}
