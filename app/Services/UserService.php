<?php
namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use App\Models\UserPending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    protected $user;
    protected $up;
    protected $comment;
    public function __construct(User $user, UserPending $up, Comment $comment)
    {
        $this->user = $user;
        $this->up = $up;
        $this->comment = $comment;
    }
    public function getAllUser()
    {
        return $this->user->all();
    }
    public function findUser($id)
    {
        return $this->user->find($id);
    }

    public function profile($id)
    {
        return $this->user->findOrFail($id);
    }
    public function createUser($token)
    {
        $up = $this->up->where('verify_token', $token)->first();
       
        if ($up && $up->expires_at >= now()) {
            $user = $this->user->create([
                'username' => $up->username,
                'display_name' => $up->display_name,
                'password' => $up->password,
                'email' => $up->email,
                'avt_url' => "https://www.facebook.com/groups/518282464857050/user/100078710535550/",
            ]);
            $user->roles()->attach(1);
            $up->delete();
            logger()->info($up);
            return true;
        }
        return false;

    }

    public function pendingUser(Request $request)
    {

        $verifyTk = $this->uniqueToken();
        $up = $this->up->create([
            'username' => $request->username,
            'display_name' => $request->display_name,
            'real_name' => $request->real_name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'avt_url' => "https://www.facebook.com/groups/518282464857050/user/100078710535550/",
            'verify_token' => $verifyTk,
            'expires_at' => now()->addMinute(30)
        ]);
        return $up;
    }

    private function uniqueToken()
    {
        do {
            $token = Str::random(32);
        } while ($this->up->where('verify_token', $token)->exists());
        return $token;
    }

    public function checkMailVerify($mail)
    {
        return $this->up->where('email', $mail)->exists();
    }

    public function checkMailUser($mail)
    {
        return $this->user->where('email', $mail)->exists();
    }

    public function getUserByComment($commentId)
    {
        $cmt = $this->comment->findOrFail($commentId);
        return $this->user->select('username')->findOrFail($cmt->user_id);
    }
}
