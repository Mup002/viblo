<?php
namespace App\Services;

use App\Models\Bookmark;
use App\Models\User;

class BookmarkService
{
    protected $bookmark;
    protected $user;
    public function __construct(Bookmark $bookmark,User $user)
    {
        $this->bookmark = $bookmark;
        $this->user =  $user;
    }
    public function updateBookmark($userId,$articleId)
    {
        $check = $this->bookmark->where('user_id',$userId)->where('article_id',$articleId)->first();
        if($check)
        {
            $check->delete();
            $user = $this->user-> where('user_id',$userId)->decrement('bookmark');
            return 'removed';
        }
        $bookmark = $this->bookmark->create([
            'user_id' => $userId,
            'article_id' => $articleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user = $this->user->where('user_id',$userId)->increment('bookmark');
        return 'inserted';
    }
}