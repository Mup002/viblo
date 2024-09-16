<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data["user"] = new UserArticleInfoResource($this->user);
        $replies = Comment::where('author_comment_root',$this->comment_id)->get();
        $data['replies'] = $this->transformData($replies); 
        return $data;
    }
    protected function transformData($replies)
    {
        return $replies->map(function($reply){
            $replyResource = new CommentResource($reply);
            $replyData = $replyResource->toArray(request());
            $cmt = Comment::where('comment_id',$reply->cmtreply_id)->first();
            $user = User::where('user_id',$cmt->user_id)->first();
            $replyData['reply_user'] = $user->username;

            return $replyData;
        });
    }
}
// protected function transformReplies($replies)
//     {
//         return $replies->map(function($reply) {
//             $replyResource = new CommentResource($reply);
//             $replyData = $replyResource->toArray(request());
//             $replyData['other'] = 'Some value'; // Thêm trường 'other' vào mỗi phản hồi
//             return $replyData;
//         });
//     }