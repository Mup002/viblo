<?php
namespace App\Services;

use App\Http\Resources\ArticleInfoResource;
use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepo;
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepo = $articleRepository;
    }
    public function getLatestArticle($page){
        $articles = $this->articleRepo->getLatestArticle($page);
        $articleResource = ArticleInfoResource::collection($articles);
        return $articleResource;
    }
    public function getArticleByTagId($tagId){
        return ArticleInfoResource::collection($this->articleRepo->getArticlesByTagId($tagId));
    }
}
