<?php
namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    protected $article;
    public function __construct(Article $article)
    {
        $this->article = $article;
    }
    public function getLatestArticle($page = 1, $perpage = 20){
        return Article::with('tags')
        ->orderBy('created_at','desc' )
        ->paginate($perpage,['*'],'page',$page);
    }
}
