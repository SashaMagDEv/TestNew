<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'thumbnail' => $this->faker->imageUrl(),
            'title' => $this->faker->sentence,
            'date' => $this->faker->date,
            'short_description' => $this->faker->paragraph,
            'likes' => $this->faker->numberBetween(0, 2000000),
        ];
    }
}
