<?php
namespace App\Services;

use App\Models\Follower;
use App\Notifications\AcceptArticle;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;

class NotificationService
{
    protected $pusher;
    protected $user;
    protected $follower;

    public function __construct(User $user, Follower $follower)
    {
        $this->config();
        $this->user = $user;
        $this->follower = $follower;
    }
    private function config()
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'), // App key
            env('PUSHER_APP_SECRET'),// App secret
            env('PUSHER_APP_ID'), // App ID
            $options
        );
    }
    public function sendNotification($data)
    {

        $message = $data['message'];
        logger()->info($message);
        $recipientId = $data['recipient_id'];
        $this->pusher->trigger('private-channel-' . $recipientId, 'notification-event', $message);

        //test public channel
        $this->pusher->trigger('public-channel', 'notification-event', $message . ' => this noti for ' . $recipientId);
    }

    public function sendSubNotification($data, $article)
    {
        $followers = $this->follower->where('follower_id', $data->user_id)->get();
        logger()->info('cac user can gui thong bao -> ' . $followers);
        foreach ($followers as $follower) {
            $message = $follower->follower_id . ' đă đăng 1 bài viết mới ' . $article->title;
            $this->pusher->trigger('private-channel-' . $follower->user_id, 'notification-event', $message);
            $data->notify(new AcceptArticle($message));
            //test public channel
            $this->pusher->trigger('public-channel', 'notification-event', $message . ' => this noti for ' . $follower->ser_id);
        }
    }

    public function getNotification($data)
    {
        
    }
}