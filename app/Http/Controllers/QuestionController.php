<?php

namespace App\Http\Controllers;

use App\Services\QuestionService;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class QuestionController extends Controller
{
    //
    protected $questionService;
    public function __construct(QuestionService $questionService){
        $this->questionService = $questionService;
    }
    public function getThreeQuestionsLatest(){
        try{
            $rs = $this->questionService->getThreeQuestionLatest();
            return response()->json($rs,200);
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }
}
