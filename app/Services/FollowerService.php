<?php
namespace App\Services;
use App\Models\User;
use App\Models\Follower;

class FollowerService
{
    protected $follower;
    protected $user;
    public function __construct(User $user, Follower $follower)
    {
        $this->user = $user;
        $this->follower = $follower;
    }
    public function updateFollower($userId,$followerId)
    {
        $check  = $this->follower->where('user_id',$userId)->where('follower_id',$followerId)->first();
        if($check){
            $check->delete();
            $user =  $this->user->where('user_id', $followerId)->decrement('user_follow');
            return "removed";
        }
        $follower = $this->follower->create([
            "user_id" => $userId,
            "follower_id" => $followerId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user =  $this->user->where('user_id',$followerId)->increment('user_follow');

        return "insert";

    }
}