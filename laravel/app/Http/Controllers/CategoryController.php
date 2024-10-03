<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Помилка на сервері'], 500);
        }
    }

    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        if (!$category) {
            return response()->json(['message' => 'Категорія не знайдена'], 404);
        }
        return response()->json($category);
    }

    public function getNewsByCategory($id, Request $request)
    {
        if (!is_numeric($id)) {
            return response()->json(['message' => 'Invalid category ID'], 400);
        }

        $news = $this->categoryService->getNewsByCategoryId($id);
        return response()->json($news);
    }
}

