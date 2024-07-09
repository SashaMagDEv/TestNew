<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\News;
use App\Models\Category;


class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Перевірка наявності категорій
        if (Category::count() === 0) {
            $this->command->error('No categories found. Please seed categories first.');
            return;
        }

        // Отримуємо всі існуючі категорії
        $categories = Category::all()->pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            News::create([
                'category_id' => $faker->randomElement($categories),
                'thumbnail' => $faker->imageUrl(),
                'title' => $faker->sentence(),
                'date' => $faker->dateTimeBetween('-1 year', 'now'),
                'short_description' => $faker->realText(200),
                'likes' => $faker->numberBetween(50, 2000000)
            ]);
        }
    }
}
