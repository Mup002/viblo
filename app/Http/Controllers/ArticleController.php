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
            $data = $this->articleService->getLatestArticle($page);
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
// public function getLatestArticle(Request $request)
// {
//     $page = $request->query('page', 1);
//     try {
//         $data = $this->articleService->getLatestArticle($page);
//         return response()->json($data, 200);
//     } catch (Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

//  $result  = ['status' => 200];
//         try{
//             $result['data'] = $this -> userService->getAllUser();
//         }catch(Exception $e){
//             $result = [
//                 'status' => 500,
//                 'error'=> $e->getMessage()
//             ];
//         }
//         return response()->json($result,$result['status']);
