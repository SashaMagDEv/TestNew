<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;


class ArticleCategorySeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ArticleCategorySeed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Category::factory()->count(5)->create();

        $this->info('Categories seeded successfully.');
    }
}
