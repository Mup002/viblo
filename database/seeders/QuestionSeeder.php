<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::where('user_id',1)->first();
        $questions = Question::factory()->count(10)->create();
        
        foreach ($questions as $question) {
            $tags = Tag::all()->random(rand(3,5));
            $user->questions()->make($question);
            $question->tags()->attach($tags);
        }
    }
}
