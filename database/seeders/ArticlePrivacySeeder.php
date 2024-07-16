<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Privacy;
class ArticlePrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $articles = Article::all();
     
        foreach($articles as $article)
        {
            $article->privacy_id = 1;
            $article->save();
        }
    }
}
