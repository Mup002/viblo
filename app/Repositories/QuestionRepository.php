<?php
namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    protected $question;
    public function __construct(Question $question){
        $this-> question = $question;
    }

    public function getThreeQuestionsLatest(){
        return Question::orderBy('created_at','desc')->take(3)->get();
    }
}

