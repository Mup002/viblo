<?php
namespace App\Services;

use App\Http\Resources\QuestionInfoResource;
use App\Repositories\QuestionRepository;

class QuestionService
{
    protected $questionRepo;
    public function __construct(QuestionRepository $questionRepo){
        $this->questionRepo = $questionRepo;
    }
    public function getThreeQuestionLatest(){
        $question = $this->questionRepo->getThreeQuestionsLatest();
        $questionResource = QuestionInfoResource::collection($question);
        return $questionResource;
    }
   
}
