<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Article;
class UpdateTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tags = Tag::all();
        foreach($tags as $tag)
        {
            $tagId = $tag->tag_id;
            $tag->articles = Article::whereHas('tags',function($query) use ($tagId){
                $query->where('tags.tag_id',$tagId);
            })->count();
    
            $tag->questions = Question::whereHas('tags',function($query) use ($tagId){
                $query->where('tags.tag_id',$tagId);
            })->count();
            $tag->save();
            // $tag = Tag::withCount(['questions as questions' => function ($query) use ($tagId) {
            //     $query->where('tag_question.tag_id', $tagId);
            // }])->find($tagId);
        }
    }
}
