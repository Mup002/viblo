<?php
namespace App\Services;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\ArticleInfoResource;
use App\Models\Article;
use App\Models\Follower;
use App\Models\Serie;
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
    protected $serie;
    public function __construct(Article $article,Follower $follower,User $user, Bookmark $bookmark,Tag $tag, Serie $serie)
    {
        $this->article = $article;
        $this->follower = $follower;
        $this->user = $user;
        $this->bookmark =  $bookmark;
        $this->tag = $tag;
    }

    public function getLatestArticle($page){
        $perpage = 20;
        $articles = $this->article::where('is_accept',1)->where('is_publish',1)->where('is_spam',0)->with('tags')
        ->orderBy('created_at', 'desc')
        ->paginate($perpage, ['*'], 'page', $page);
        $articleResource = ArticleInfoResource::collection($articles);
        return $articleResource;
    }

    public function getArticleByTagId($tagId,$page){
        $perPage = 20;
        return ArticleInfoResource::collection($this->article->whereHas('tags', function ($query) use ($tagId) {
            $query->where('is_accept',1)->where('is_publish',1)->where('is_spam',0)->where('tags.tag_id', $tagId);
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page));
    }

    public function getArticleByFollower($userId,$page)
    {
        $perPage = 20;
        $user = $this->user->find($userId);
        $followers = $this->follower->where('user_id',$user->user_id)->get();

        $articles = collect();
        foreach($followers as $follower)
        {
            $followerArticles = $this->article->where('is_accept',1)->where('is_publish',1)->where('is_spam',0)->where('user_id',$follower->follower_id)->get();
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
            $article = $this->article->where('is_accept',1)->where('is_publish',1)->where('article_id',$bookmark->article_id)->get();
            $articles = $articles->merge($article);
        }

        $sortedArticles = $articles->sortByDesc('created_at');
        $paginateArticles = $this->paginate($sortedArticles,$perPage, $page);
        return ArticleInfoResource::collection($paginateArticles);
    }

    public function createArticle(StorePostRequest $request)
    {
       
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
        $article -> address_url = Str::slug($request->title) . '-' . rand(10000,999999999999);
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
    public function getArticleByUrl($address_url)
    {
        $article = $this->article->where('is_accept',1)
        ->where('is_publish',1)
        ->where('is_spam',0)
        ->where('address_url',$address_url)
        ->first();
        $article->increment('views');
        $articleResoure = new ArticleInfoResource($article);
        return $articleResoure;
    }

    public function getArticleAuthByUrl($address_url)
    {
        $article = $this->article->where('address_url',$address_url)->first();
        return $article;
    }

    public function getArticleAuthorRelate($url)
    {
        $article = $this->article->where('address_url',$url)->first();
        $articles = $this->article->where('user_id',$article->user_id)
        ->where('article_id', '!=', $article->article_id)
        ->where('is_accept',1)->where('is_publish',1)->where('is_spam',0)->take(12)->get();
        $articleResource = ArticleInfoResource::collection($articles);
        return $articleResource;
    }

    public function getArticleBySerie($serieId)
    {
        $articles = $this->article->where('serie_id',$serieId)->get();
        return $articles;
    }
    public function getArticleByTag($tagId)
    {
        $tag = $this->tag->findOrFail($tagId);
        $articles = $tag->articles()->get();
        return $articles;
    }
    public function getArticleRelate($url)
    {   
        //Tieu chi thu nhat : co cung tag (n tag)  (tc1)
        //Tieu chi thu hai : trong cung 1 serie  (tc2)
        //Tieu chi thu ba : khoang cach title  (tc3)
        // Do tuong dong =  tc3 * 0.3 + tc2 * 0.4 + tc1 * 0.8 * n
        //--Bat dau--//
        //khoi tao collect chua ket qua : key = article_id , value = do tuong dong
        $articleMap = collect();
        // tim bai viet theo url dc truyen vao
        $article = $this->article->where('address_url',$url)->first();
        // lay ra cac tag cua bai viet do
        $tags = $article->tags()->get();
        // danh gia theo tieu chi thu nhat
        foreach($tags as $tag)
        {
            $articles = $tag->articles()->where('articles.article_id', '!=', $article->article_id)->get();
            foreach($articles as $article)
            {
                $count = 1;
                if($articleMap->has($article->article_id))
                {
                    $count = $articleMap->get($article->article_id);
                    $count +=1 ;    
                }
                $articleMap->put($article->article_id, $count);
            }
        }
        //ket qua dau ra cua tieu chi thu nhat
        $articleMap = $articleMap->map(function($value){
            return $value * 0.8;
        });
        //danh gia theo tieu chi thu hai
        foreach($articleMap->keys() as $key)
        {
            $checkArticle = $this->article->findOrFail($key);
            if($article->serie_id === $checkArticle->serie_id)
            {
                $count = $articleMap->get($key);
                $count += 0.4;
                $articleMap->put($key,$count);
            }
        }
        if ($article) {
            $filteredArticleMap = $articleMap->reject(function ($value, $key) use ($article) {
                return $key == $article->article_id;
            });
            $sortedArticleMap = $filteredArticleMap->sortByDesc(function ($value, $key) {
                return $value;
            });
            $top12Articles = $sortedArticleMap->take(12);
        }
        $rs = collect();
        foreach($top12Articles->keys() as $key)
        {
            $rs->push($this->article->findOrFail($key));
        }
        $rs = ArticleInfoResource::collection($rs);
        return $rs;

    }

    public function getArticlesByAuthor($auid,$page)
    {
        $perpage = 20;
        $articles = $this->article->where('user_id',$auid)
        ->where('is_accept',1)
        ->where('is_publish',1)
        ->where('is_spam',0)
        ->orderBy('created_at', 'desc')
        ->paginate($perpage, ['*'], 'page', $page);
        return $articles;
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
