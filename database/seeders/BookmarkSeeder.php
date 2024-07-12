<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::inRandomOrder()->limit(rand(30,50))->get();
        foreach($users as $user)
        {
            $articles = Article::inRandomOrder()->limit(rand(5,20))->get();
            foreach($articles as $article)
            {
                DB::table('bookmarks')->insert([
                    'user_id' => $user->user_id,
                    'article_id' => $article->article_id,
                    'created_at' =>now(),
                    'updated_at' => now()
                ]);
                $user->increment('bookmark');
            }
        }
    }
}
