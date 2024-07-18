<?php
namespace App\Services;

use App\Http\Resources\ArticleInfoResource;
use App\Models\Article;
use App\Models\Follower;
use App\Models\User;
use App\Models\Bookmark;
use App\Models\Tag;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class ArticleService
{

    protected $article;
    protected $follower;
    protected $user;
    protected $bookmark;
    protected $tag;
    public function __construct(Article $article,Follower $follower,User $user, Bookmark $bookmark,Tag $tag)
    {
        $this->article = $article;
        $this->follower = $follower;
        $this->user = $user;
        $this->bookmark =  $bookmark;
        $this->tag = $tag;
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

    public function createArticle(Request $request)
    {
        $request->validate([
            'title'=> 'required|string',
            'tags'=>'required|array',
            'tags.*'=>[
                'numeric',
                'min: -9223372063854775808',
                'max: 9223372063854775808',
                'exists:tags,tag_id'
            ],
            'privacy_id'=>'required'
        ]);
        $user = Auth::user();
        $article = new Article();
        $article -> title = $request -> title;
        $article -> content = $request -> content;
        $article -> user_id = $user->user_id;
        $article -> privacy_id = $request -> privacy_id;
        // neu chon dat lich thi se them truong published_at chi thoi gian bai viet duoc phat hanh
        if($request->privacy_id == 2)
        {
            $article -> published_at = $request -> published_at;
        }
        $article -> slug = Str::slug($request->title);
        $article -> address_url = Str::slug($request->title) . '/' . rand(10000,999999999999);
        $article->save();

        // sau khi luu bai viet se tang article ben use
        $user->increment('article');
        // luu vao bang trung gian
        $article->tags()->attach($request->tags);
        foreach($request->tags as $tagId)
        {
            $tag = $this->tag->find($tagId);
            $tag->increment('articles');
        }
        $articleResource = new ArticleInfoResource($article);
        return $articleResource;
    }
    public function updateArticle(Request $request,Article $article)
    {
        $article -> update($request->all());
        $articleResource = new ArticleInfoResource($article);
        return $articleResource;
    }
    public function findArticleById($articleId)
    {
        return $this->article->findOrFail($articleId);
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
