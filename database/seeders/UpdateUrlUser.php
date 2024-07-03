<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUrlUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = DB::table('users')->get();
        $imgUrls = [
            'https://images.viblo.asia/avatar/82afa6c9-073b-419a-aceb-ae889b85c554.jpg',
            'https://images.viblo.asia/avatar/6d93c6d2-7685-4eb7-97bd-1cb5a4dbc10c.png',
            'https://images.viblo.asia/avatar/6e6df3d9-b9c0-47c2-a7b0-67d82f5e80e7.jpg',
            'https://images.viblo.asia/avatar/419fbca7-ba18-4e01-bf2b-ff7e9d5eebf6.jpg',
            'https://images.viblo.asia/avatar/7152fc7d-6e42-4244-b237-3834cd2b9a5c.png',
            'https://images.viblo.asia/avatar/c7a9915f-9a2d-49b1-bb60-e2ca0d2c6611.jpg',
            'https://images.viblo.asia/avatar/f80ed89c-393c-43c4-bbde-f5db845ed676.jpg',
            'https://images.viblo.asia/avatar/5a6b032d-e36d-401d-b598-ce79501f9d82.png',
            'https://images.viblo.asia/avatar/1c10e2d9-f2b2-4f79-84af-c5a5e5b57ceb.jpg',
            'https://images.viblo.asia/avatar/db8e51a4-92fc-495d-aec1-eb96f1c51fd3.jpg',
            'https://images.viblo.asia/avatar/8ff6d9a6-97e6-4a54-8763-dbbeac8d736d.jpg',
            'https://images.viblo.asia/avatar/2bed1b41-50ef-4003-a2a7-2a31ba99f7d7.jpg',
            'https://images.viblo.asia/avatar/5547859f-80e9-4377-98e4-5f1563540bd7.jpg',
            'https://images.viblo.asia/avatar/65a84cb0-8a30-48ef-a615-c4271127d236.jpg',
            'https://images.viblo.asia/avatar/a76a90cf-a4de-4545-8926-8eb057d8fe94.jpg',
            'https://images.viblo.asia/avatar/5ea6f6d9-8c57-4262-b37e-1f26e3bdd95f.jpg',
            'https://images.viblo.asia/avatar/213bf51e-f4a0-4ee1-8afb-65e04a4e07d1.jpg',
            'https://images.viblo.asia/avatar/4ed8a757-5ab5-409b-aabc-b7f80a435282.jpg',
            'https://viblo.asia/images/avt-level-silver.png',
            'https://images.viblo.asia/avatar/a137ff06-5ae4-40d8-bc6a-2da50fe0ec21.png',
            'https://images.viblo.asia/avatar/de2c64d0-5d0e-49f6-baf3-619fa9e8bd51.jpg',

        ];

        foreach($users as $user){
            DB::table('users')
            ->where('user_id',$user->user_id)
            ->update([
                'avt_url' => $imgUrls[array_rand($imgUrls)]
            ]);
        }
    }
}
