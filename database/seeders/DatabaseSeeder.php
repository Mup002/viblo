<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this -> call([
            // RoleSeeder::class
            UserSeeder::class
            // TagSeeder::class
            // ArticleTagSeeder::class,
            // TagQuestionSeeder::class,
            // UpdateUrlUser::class,
            // SerieTagSeeder::class,
            // UpdateTagArticle::class
            // UserRoleSeeder::class
            // PermissionSeeder::class
            // PermissionRole::class
            // FollowerSeeder::class
            // BookmarkSeeder::class
            // PrivacySeeder::class
            // ArticlePrivacySeeder::class
        ]);
    }
}

