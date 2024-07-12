<?php

namespace App\Http\Controllers;

use App\Services\BookmarkService;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    //
    protected $bookmarkService;
    public function __construct(BookmarkService $bookmarkService)
    {
        $this->bookmarkService = $bookmarkService;
    }

    public function updateBookmark(Request $request)
    {
        $userId = $request->query('userId');
        $articleId = $request->query('articleId');
        return response()->json(['message'=>$this->bookmarkService->updateBookmark($userId, $articleId)],200);
    }
}
