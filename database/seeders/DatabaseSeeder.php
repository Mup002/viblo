<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this -> call([
            // RoleSeeder::class,
            // TagSeeder::class,
            // PermissionSeeder::class,
            PermissionRole::class,
            // UserSeeder::class,
            // UserRoleSeeder::class,

            // ArticleTagSeeder::class,
            // TagQuestionSeeder::class,
            // UpdateUrlUser::class,
            // SerieTagSeeder::class,
            // FollowerSeeder::class,
            // BookmarkSeeder::class,
            // PrivacySeeder::class,
            // UpdateUserSeeder::class,
            // UpdateTagSeeder::class,

        ]);
    }
}

