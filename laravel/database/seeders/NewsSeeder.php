<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $news = [
            [
                'category_id' => 1,
                'thumbnail' => 'https://example.com/image1.jpg',
                'title' => 'Tech News 1',
                'date' => '2024-01-01',
                'short_description' => 'Short description of tech news 1',
                'likes' => 120
            ],
            [
                'category_id' => 2,
                'thumbnail' => 'https://example.com/image2.jpg',
                'title' => 'Health News 1',
                'date' => '2024-01-02',
                'short_description' => 'Short description of health news 1',
                'likes' => 90
            ],
        ];

        foreach ($news as $newsItem) {
            News::create($newsItem);
        }
    }
}
