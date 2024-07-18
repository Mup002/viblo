<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    protected $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    public function createCmt(Request $request)
    {
        $this->authorize('write-comment');
        return response()->json(['message'=>$this->commentService->createComment($request)]);
    }

    public function editCmt(Request $request)
    {
        $this->authorize('edit-comment',$this->commentService->findCommentById($request->query('id')));
        return response()->json(['message'=>$this->commentService->updateComment($request)]);
    }
    public function allCmt(Request $request)
    {
        
        return response()->json($this->commentService->allComment($request));
    }
}
