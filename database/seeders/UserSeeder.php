<?php

namespace Database\Seeders;

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
        //
        // User::factory()
        // -> count(25)
        // ->hasArticles(random_int(5,10))
        // ->create()
        User::factory()
        ->count(25)
        ->hasQuestions(random_int(0,3))
        ->create();
    }
}
