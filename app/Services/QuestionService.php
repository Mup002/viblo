<?php
namespace App\Services;

use App\Http\Resources\QuestionInfoResource;
use App\Models\Question;
use App\Repositories\QuestionRepository;

class QuestionService
{

    protected $question;
    public function __construct(Question $question){
        $this->question = $question;
    }
    public function getThreeQuestionLatest(){
        $question = $this->question->orderBy('created_at','desc')->take(3)->get();
        $questionResource = QuestionInfoResource::collection($question);
        return $questionResource;
    }
    public function getQuestionsByAuthor($auid,$page){
        $perpage = 20;
        $question = $this->question->where('user_id',$auid)
        ->orderBy('created_at','desc')
        ->paginate($perpage,['*'],'page',$page);
        return $question;
    }
   
}
