<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Helpers\PaginateHelper;
class ArticleController extends Controller
{
    //
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }


    public function getLatestArticle(Request $request)
    {
        $page = $request->query('page', 1);
        try {
            $data = $this->articleService->getLatestArticle($page);
                       $article = $data->items();

            $rs = [
                'page' => PaginateHelper::paginate($data),
                'article' => $article
            ];
            return response()->json($rs, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getArticlesByTagId(Request $request){
        $page = $request->query('page',1);
        $tagId = $request->query('tagId');
        try
        {
            $data = $this->articleService->getArticleByTagId($tagId,$page);

            $article = $data->items();
            $rs = [
                'page' => PaginateHelper::paginate($data),
                'article' => $article
            ];

            return response()->json($rs,200);
        }
        catch(Exception $e)
        {
            return response()->json(['error'=>$e->getMessage()],200);
        }
    }

    public function getArticleByFollower(Request $request){
        $page = $request->query('page',1);
        $userId = $request->query('userId');
        $data = $this->articleService->getArticleByFollower($userId,$page);

        $rs = [
            'page' => PaginateHelper::paginate($data),
            'article' => $data
        ];

        return response()->json($rs,200);
    }

    public function getArticleByBookmark(Request $request)
    {
        $userId = $request->query('userId');
        $page = $request->query('page');
        $data =  $this->articleService->getArticleByBookmark($userId,$page);

        $rs = [
            'page' => PaginateHelper::paginate($data),
            'article' => $data->items()
        ];

        return response()->json($rs,200);
    }

    public function createArticleByUser(Request $request)
    {
        $this->authorize('create-article');
        return response()->json($this->articleService->createArticle($request));
    }

    public function updateArticle(Request $request,$articleId)
    {
        $article = $this->articleService->findArticleById($articleId);
        $this->authorize('delete-update-article', $article);
        if($request->has('is_publish'))
        {
            $this->authorize('publish-update', $article);
        }
        if($request->has('is_accept'))
        {
            $this->authorize('accept-update', $article);
        }
        return response()->json($this->articleService->updateArticle($request,$article));
    }

}
