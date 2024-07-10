<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Exception;
use Illuminate\Http\Request;

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
            $paginationInfo = [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' =>$data->perPage(),
                'total' => $data->total(),
            ];
            $article = $data->items();

            $rs = [
                'page' => $paginationInfo,
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
            $paginationInfo = [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ];
            $article = $data->items();
            $rs = [
                'page' => $paginationInfo,
                'article' => $article
            ];

            return response()->json($rs,200);
        }
        catch(Exception $e)
        {
            return response()->json(['error'=>$e->getMessage()],200);
        }
    }

}
