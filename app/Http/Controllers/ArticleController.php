<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleInfoResource;
use App\Notifications\AcceptArticle;
use App\Services\ArticleService;
use App\Services\NotificationService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Helpers\PaginateHelper;
use Pusher\Pusher;

class ArticleController extends Controller
{
    //
    protected $articleService;
    protected $userService;
    protected $notification;

    public function __construct(ArticleService $articleService, UserService $userService, NotificationService $notificationService)
    {
        $this->articleService = $articleService;
        $this->userService = $userService;
        $this->notification = $notificationService;
    }


    public function getLatestArticle(Request $request)
    {
        $page = $request->query('page', 1);
        try {
            $data = $this->articleService->getLatestArticle($page);
            $article = $data->items();

            $rs = [
                'page' => PaginateHelper::paginate($data),
                'article' => $article
            ];
            return response()->json($rs, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getArticlesByTagId(Request $request)
    {
        $page = $request->query('page', 1);
        $tagId = $request->query('tagId');
        try {
            $data = $this->articleService->getArticleByTagId($tagId, $page);

            $article = $data->items();
            $rs = [
                'page' => PaginateHelper::paginate($data),
                'article' => $article
            ];

            return response()->json($rs, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    public function getArticleByFollower(Request $request)
    {
        $page = $request->query('page', 1);
        $userId = $request->query('userId');
        $data = $this->articleService->getArticleByFollower($userId, $page);

        $rs = [
            'page' => PaginateHelper::paginate($data),
            'article' => $data
        ];

        return response()->json($rs, 200);
    }

    public function getArticleByBookmark(Request $request)
    {
        $userId = $request->query('userId');
        $page = $request->query('page');
        $data = $this->articleService->getArticleByBookmark($userId, $page);

        $rs = [
            'page' => PaginateHelper::paginate($data),
            'article' => $data->items()
        ];

        return response()->json($rs, 200);
    }

    public function createArticleByUser(Request $request)
    {
        $this->authorize('create-article');
        return response()->json($this->articleService->createArticle($request));
    }

    public function updateArticle(Request $request, $articleId)
    {
        $article = $this->articleService->findArticleById($articleId);
        $this->authorize('delete-update-article', $article);
        if ($request->has('is_publish')) {
            $this->authorize('publish-update', $article);
        }
        if ($request->has('is_accept')) {
            $this->authorize('accept-update', $article);
            $user = $this->userService->findUser($article->user_id);
            $message = 'Bài viết ' . $article->title . ' đã được chấp thuận';
            $data = [
                'article' => $articleId,
                'message' => $message,
                'recipient_id' => $user->user_id,
            ];
            $user->notify(new AcceptArticle($data));
            $this->notification->sendNotification($data);

            if ($article->published_at == null) {
                $this->notification->sendSubNotification($user, $article);
            }

        }
        if ($request->has('is_spam')) {
            $this->authorize('accept-update', $article);
            if ($article->is_spam == 1) {
                $message = 'Bài viết ' . $article->title . ' đã được xóa khỏi mục spam';
                $data = [
                    'article' => $articleId,
                    'message' => $message,
                    'recipient_id' => $user->user_id,
                ];
                $user->notify(new AcceptArticle($data));
                $this->notification->sendNotification($data);

                return response()->json($this->articleService->updateArticle($request, $article));
            }
            $user = $this->userService->findUser($article->user_id);
            $message = 'Bài viết ' . $article->title . ' đã bị đánh dấu là spam';
            $data = [
                'article' => $articleId,
                'message' => $message,
                'recipient_id' => $user->user_id,
            ];
            $user->notify(new AcceptArticle($data));
            $this->notification->sendNotification($data);
        }
        return response()->json($this->articleService->updateArticle($request, $article));
    }
    public function getArticle($address_url)
    {
        return response()->json($this->articleService->getArticleByUrl($address_url));
    }
    public function getArticleAuth($address_url)
    {
        $article = $this->articleService->getArticleAuthByUrl($address_url);
        $this->authorize('delete-update-article',$article);
        $articleResoure = new ArticleInfoResource($article);
        return response()->json($articleResoure);
    }
    public function getaArticleRelateByAuthor($url)
    {
        return response()->json($this->articleService->getArticleAuthorRelate($url));
    }
    public function getArticleByTag($tagId)
    {
        return response()->json($this->articleService->getArticleByTag($tagId));
    }

    public function getArticleRelate($url)
    {
        return response()->json($this->articleService->getArticleRelate($url));
    }
    
    public function getArticlesByAuthor(Request $request,$auid)
    {
        $page = $request->query('page');
        $articles = $this->articleService->getArticlesByAuthor($auid,$page);
        $articlesResource = ArticleInfoResource::collection($articles);

        $rs = [
            'page' => PaginateHelper::paginate($articlesResource),
            'article' => $articlesResource
        ];

        return response()->json($rs);
        // return response()->json($articlesResource);
    }

}
