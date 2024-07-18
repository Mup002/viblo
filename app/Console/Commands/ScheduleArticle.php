<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
class ScheduleArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-article';

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
        Article::where('privacy_id', 2)
        ->where('published_at', '<=',now())
        ->update(['privacy_id' => 1]);
    }
}
