<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Database\Seeders\ArticleCategorySeeder;
use Database\Seeders\ArticleSeeder;

class SeedAllData extends Command
{
    protected $signature = 'db:seed-all';
    protected $description = 'Seed the database with categories and articles';

    public function handle()
    {
        $this->info('Seeding categories...');
        $this->call(ArticleCategorySeeder::class);

        $this->info('Seeding articles...');
        $this->call(ArticleSeeder::class);

        $this->info('Database seeding completed.');
    }
}
