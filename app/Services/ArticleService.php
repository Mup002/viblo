<?php
namespace App\Services;

use App\Http\Resources\ArticleInfoResource;
use App\Models\Article;
use App\Models\Follower;
use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Pagination\LengthAwarePaginator;
class ArticleService
{

    protected $article;
    protected $follower;
    protected $user;
    protected $bookmark;
    public function __construct(Article $article,Follower $follower,User $user, Bookmark $bookmark)
    {
        $this->article = $article;
        $this->follower = $follower;
        $this->user = $user;
        $this->bookmark =  $bookmark;
    }
    public function getLatestArticle($page){
        $perpage = 20;
        $articles = $this->article::with('tags')
        ->orderBy('created_at', 'desc')
        ->paginate($perpage, ['*'], 'page', $page);
        $articleResource = ArticleInfoResource::collection($articles);
        return $articleResource;
    }
    public function getArticleByTagId($tagId,$page){
        $perPage = 20;
        return ArticleInfoResource::collection($this->article->whereHas('tags', function ($query) use ($tagId) {
            $query->where('tags.tag_id', $tagId);
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page));
    }
    ////

    public function getArticleByFollower($userId,$page)
    {
        $perPage = 20;
        $user = $this->user->find($userId);
        $followers = $this->follower->where('user_id',$user->user_id)->get();

        $articles = collect();
        foreach($followers as $follower)
        {
            $followerArticles = $this->article->where('user_id',$follower->follower_id)->get();
            $articles = $articles->merge($followerArticles);
        }

        $sortedArticles = $articles->sortByDesc('created_at');
        $paginatedArticles = $this->paginate($sortedArticles, $perPage, $page);
        return ArticleInfoResource::collection($paginatedArticles);

    }
    public function getArticleByBookmark($userId, $page)
    {
        $perPage = 20;
        $user =  $this->user->find($userId);
        $bookmarks = $this ->bookmark->where('user_id',$user->user_id)->get();

        $articles = collect();
        foreach($bookmarks as $bookmark)
        {
            $article = $this->article->where('article_id',$bookmark->article_id)->get();
            $articles = $articles->merge($article);
        }

        $sortedArticles = $articles->sortByDesc('created_at');
        $paginateArticles = $this->paginate($sortedArticles,$perPage, $page);
        return ArticleInfoResource::collection($paginateArticles);
    }

    //////////
    protected function paginate($items, $perPage, $page)
    {
        $offset = ($page - 1) * $perPage;
        return new LengthAwarePaginator(
            $items->slice($offset, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }


}
