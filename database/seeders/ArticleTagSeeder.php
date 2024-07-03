<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Repositories\ArticleRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $article;
    protected $tag;
    public function __construct(
        Article $article,
        Tag $tag
    ){
        $this->article = $article;
        $this->tag = $tag;
    }
    public function run(): void
    {
        //
        $articles = $this->article::all();
        $tags = $this->tag::all();

        foreach($articles as $article){
            $randomTags = $tags->random(rand(2,3));
            foreach($randomTags as $tag){
                DB::table('article_tag')->insert([
                    'article_id' => $article->article_id,
                    'tag_id' => $tag -> tag_id,
                    'created_at' => now(),
                    'updated_at' =>now(),
                ]);
            }
        }
    }
}
