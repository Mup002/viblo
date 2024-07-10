<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'users-all',
            'users-view',
            'users-create',
            'users-edit',
            'users-delete',
            'roles-all',
            'roles-view',
            'roles-create',
            'roles-edit',
            'roles-delete',
            'permissions-all',
            'permissions-view',
            'permissions-create',
            'permissions-edit',
            'permissions-delete',
        ];

        $permissions = array_map(function ($name) {
            return [
                'name' => $name,
                'created_at' => now(),
            ];
        }, $permissions);

        DB::table('permissions')->insert($permissions);
    }
}
