<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        //
        $user168 = User::find(168);
        $followers = User::inRandomOrder()->limit(rand(10, 20))->get();
        foreach($followers as $follower)
        {
            DB::table('followers')->insert([
                'user_id'=> $user168->user_id,
                'follower_id' => $follower->user_id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
            DB::table('users')
            ->where('user_id',$follower->user_id)
            ->increment('user_follow');
        };
    }
}
