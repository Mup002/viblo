<?php
namespace App\Services;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\User;

class BookmarkService
{
    protected $bookmark;
    protected $user;
    protected $article;
    public function __construct(Bookmark $bookmark,User $user, Article $article)
    {
        $this->bookmark = $bookmark;
        $this->user =  $user;
        $this->article = $article;
    }
    public function updateBookmark($userId,$articleId)
    {
        $article = $this->article->where('article_id',$articleId)->first();
        if($article->is_accept == 0 || $article->is_publish == 2 || $article->is_publish == 4)
        {
            return 'dont have permission';
        }
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