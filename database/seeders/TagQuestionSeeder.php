<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected  $tag;
    protected $question;
    public function __construct(Tag $tag,Question $question){
        $this->tag = $tag;
        $this->question = $question;
    }
    public function run(): void
    {
        //
        $tags = $this->tag::all();
        $questions = $this -> question::all();

        foreach($questions as $question){
            $randomTags = $tags -> random(rand(1,3));

            foreach($randomTags as $tag){
                DB::table('tag_question')->insert([
                    'question_id' => $question -> question_id,
                    'tag_id' => $tag -> tag_id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
            }
        }
    }
}
