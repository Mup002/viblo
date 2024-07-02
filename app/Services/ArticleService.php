<?php
namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepo;
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepo = $articleRepository;
    }
    public function getLatestArticle($page){
        return $this->articleRepo->getLatestArticle($page);
    }
}
