<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
class UpdateUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cmts = Comment::all();
        $users = User::all();
        foreach($users as $user)
        {
            foreach($cmts as $cmt)
            {
                if($cmt->cmtreply_id == 0 && $user->user_id == $cmt->user_id)
                {
                    $user->increment('answer');
                }
            }
        }

    }
}
