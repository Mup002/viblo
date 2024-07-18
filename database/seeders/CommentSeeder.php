<?php

namespace Database\Seeders;

use Database\Factories\CommentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Comment::factory()
        ->count(25)
        ->create();
    }
}
