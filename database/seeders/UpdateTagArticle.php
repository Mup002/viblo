<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTagArticle extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        //
        $tag1 = Tag::where('tagname', "Editor's Choice")->first();
        $tag2 = Tag::where('tagname', 'Trending')->first();
        $articles = Article::inRandomOrder()->take(40)->get();

        foreach($articles as $article){
            if(rand(0,1)){
                DB::table('article_tag')->insert([
                    'article_id' => $article->article_id,
                    'tag_id' => $tag1->tag_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if(rand(0,1)){
                DB::table('article_tag')->insert([
                    'article_id' => $article -> article_id,
                    'tag_id' => $tag2 -> tag_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        };

    }
}
