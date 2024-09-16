<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateUrlArticle extends Seeder
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
            $url = $article->address_url;
            
            $newUrl = str_replace('/', '-', $url);
            $article -> address_url = $newUrl;
            $article ->save();
        }
    }
}
