<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Question;
use App\Models\Serie;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seeder_user_article
        // User::factory()
        // -> count(25)
        // ->hasArticles(random_int(5,10))
        // ->create();
        // seeder_question_article
        User::factory()
        ->count(25)
        ->hasQuestions(random_int(5,10))
        ->create();

        // User::factory()
        // ->count(10)
        // ->has(Serie::factory()->count(1))
        // ->create();

        // $user = new User();
        // $user-> username = 'user1';
        // $user-> display_name = 'Mvu';
        // $user-> real_name = 'bui minh vu';
        // $user-> password =  Hash::make('1234');
        // $user->email = 'clonemup01@gmail.com';
        // $user->avt_url = 'https://www.facebook.com/groups/518282464857050/user/100078710535550/';

        // $user->save();

        // $articles = Article::factory()->count(rand(1,5))->create();

        // $tags  = Tag::all();

        // foreach($articles as $article)
        // {
        //     $user->articles()->save($article);
        //     $randomTags = $tags->random(rand(3,5));
        //     $article->tags()->attach($randomTags);
        // }

    
        
    }
}
