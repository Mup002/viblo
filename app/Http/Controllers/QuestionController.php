<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginateHelper;
use App\Http\Resources\QuestionInfoResource;
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
    public function getQuestionByAuthor(Request $request, $auid){
        $page = $request->query('page');
        $question = $this->questionService->getQuestionsByAuthor($auid,$page);
        $questionResource = QuestionInfoResource::collection($question);

        $rs = [
            'page' => PaginateHelper::paginate($questionResource),
            'question' => $questionResource
        ];

        return response()->json($rs);
    }
}
