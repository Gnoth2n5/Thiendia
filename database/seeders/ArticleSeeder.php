<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing admin users
        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();

        if ($admins->isEmpty()) {
            // Create a default admin if none exists
            $admin = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'super_admin',
            ]);
            $admins = collect([$admin]);
        }

        // Create sample articles
        Article::factory()
            ->count(20)
            ->published()
            ->create([
                'author_id' => $admins->random()->id,
            ]);

        // Create featured articles
        Article::factory()
            ->count(5)
            ->published()
            ->featured()
            ->create([
                'author_id' => $admins->random()->id,
            ]);

        // Create articles by category
        $categories = ['tin_tuc', 'huong_dan', 'thong_bao', 'su_kien'];

        foreach ($categories as $category) {
            Article::factory()
                ->count(3)
                ->published()
                ->category($category)
                ->create([
                    'author_id' => $admins->random()->id,
                ]);
        }

        // Create some draft articles
        Article::factory()
            ->count(5)
            ->create([
                'status' => 'draft',
                'author_id' => $admins->random()->id,
            ]);
    }
}
