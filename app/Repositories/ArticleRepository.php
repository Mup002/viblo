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

    public function getLatestArticle($page = 1, $perpage = 20)
    {
        return Article::with('tags')
            ->orderBy('created_at', 'desc')
            ->paginate($perpage, ['*'], 'page', $page);
    }

    public function getArticlesByTagId($tagId, $page = 1, $perPage = 20)
    {
        return $this->article->whereHas('tags', function ($query) use ($tagId) {
            $query->where('tags.tag_id', $tagId);
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}

// public function getArticlesByTagId($tagIds, $page = 1, $perPage = 20)
//     {
//         return $this->article->whereHas('tags', function ($query) use ($tagIds) {
//                 $query->whereIn('tags.id', $tagIds);
//             })
//             ->orderBy('created_at', 'desc')
//             ->paginate($perPage, ['*'], 'page', $page);
//     }
