<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Article;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();
        $articles = Article::all();
        $questions = Question::all();
        foreach($users as $user)
        {
            foreach($articles as $article)
            {
                if($article->user_id == $user->user_id)
                {
                    $user->increment('article');
                }
            }
        }
        foreach($users as $user)
        {
            foreach($questions as $question)
            {
                if($question->user_id == $user->user_id)
                {
                    $user->increment('question');
                }
            }
        }
    }
}
