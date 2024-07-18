<?php
namespace App\Services;

use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Question;
use Auth;
use Illuminate\Http\Request;
use App\Rules\OnlyOneField;
class CommentService
{
    protected $comment;
    protected $article;
    protected $question;

    public function __construct(Comment $comment, Article $article, Question $question)
    {
        $this->comment = $comment;
        $this->article = $article;
        $this->question = $question;
    }
    public function createComment(Request $request)
    {
        $request->merge(['only_one' => 'dummy_value']);
        $validatedData = $request->validate([       
            'reply_to' => 'numeric',    
            'content' => 'required|string',
            'article_id' => ['sometimes', 'numeric'],
            'question_id' => ['sometimes', 'numeric'],
            'only_one' => [new OnlyOneField()],
        ]);
        $cmt = new Comment();
        $cmt->user_id = Auth::user()->user_id;
        $cmt->content = $validatedData['content'];
        if(array_key_exists('reply_to',$validatedData)){
            $cmt->cmtreply_id = $validatedData['reply_to'];
        }
        if(array_key_exists('article_id',$validatedData)){
            $article = $this->article->find($validatedData['article_id']);
            if($article)
            {
                $article->comments()->save($cmt);
            }
            
        }
        if(array_key_exists('question_id',$validatedData)){
            $question = $this->question->find($validatedData['question_id']);
            if($question)
            {
                $question->comments()->save($cmt);
            }
            if(!array_key_exists('reply_to',$validatedData)){
                Auth::user()->increment('answer');
            }
        }
        return "created";
    }

    public function updateComment(Request $request)
    {
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'content' => 'required|string'
        ]);
        $cmt = $this->comment->findOrFail($validatedData['id']);
        $cmt->update([
            'content' => $validatedData['content']
        ]);
        return "updated";
    }
    public function findCommentById($cmtId)
    {
        return $this->comment->find($cmtId);
    }
    public function allComment(Request $request)
    {
        $request->merge(['only_one' => 'dummy_value']);
        $validatedData = $request->validate([
            'article_id' => ['sometimes', 'numeric'],
            'question_id' => ['sometimes', 'numeric'],
            'only_one' => [new OnlyOneField()],
        ]);
        if(array_key_exists('article_id',$validatedData))
        {
            $article = $this->article->findOrFail($validatedData['article_id']);
            $cmts = collect();
            foreach($article->comments as $cmt){
                if($cmt->is_publish == 1)
                {
                    $cmts -> push($cmt);
                }
            }
            return CommentResource::collection($cmts);
        }
        // return $this->comment->where('is_publish',1)->where('commentable_type',$able_type)->where->get();
    }
}