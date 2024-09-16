<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\AcceptArticle;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use App\Models\Article;
use Illuminate\Log\Logger;

class ScheduleArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-article';

    protected $noti;
    public function __construct(NotificationService $noti)
    {
        parent::__construct();
        $this->noti = $noti;
    }
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Đăng bài viết đã được hẹn trước';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        logger('app:schedule-article');
        $articles = Article::where('privacy_id', 2)->get();
        foreach($articles as $article)
        {
            if($article->published_at <= now())
            {
                $article->update(['privacy_id' => 1]);
                $user = User::where('user_id',$article->user_id)->first();
            
                $this->noti->sendSubNotification($user,$article);

                logger('app:schedule-article => send notification');
            }
            
        }
        
           
    }
}
 // ->where('published_at', '<=', now())
            // ->update(['privacy_id' => 1]);