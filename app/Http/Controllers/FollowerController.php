<?php

namespace App\Http\Controllers;

use App\Services\FollowerService;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //
    protected $followerService;
    public function __construct(FollowerService $followerService)
    {
        $this->followerService =  $followerService;
    }
    public function updateFollow(Request $request)
    {
        $userId  = $request->query('userId');
        $followId = $request->query('followId');
        return response()->json(
            ['message'=> $this->followerService->updateFollower($userId,$followId)],
          200);
    }
}
