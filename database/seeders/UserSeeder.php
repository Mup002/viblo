<?php

namespace Database\Seeders;

use App\Models\Serie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        // ->create()
        // seeder_question_article
        // User::factory()
        // ->count(25)
        // ->hasQuestions(random_int(0,3))
        // ->create();

        User::factory()
        ->count(10)
        ->has(Serie::factory()->count(1))
        ->create();

    }
}
