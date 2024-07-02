<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Exception;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    protected $articleService;
    public function __construct(ArticleService $articleService){
        return $this->articleService = $articleService;
    }
    public function getLatestArticle(Request $request){
        $page = $request->query('page',1);
        $rs = ['status' => 200];
        try{
            $rs['data'] = $this -> articleService->getLatestArticle($page);
        }catch(Exception $e){
            $rs = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($rs,$rs['status']);
    }
}
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
