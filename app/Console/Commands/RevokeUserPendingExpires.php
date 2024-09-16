<?php

namespace App\Console\Commands;

use App\Models\UserPending;
use Illuminate\Console\Command;

class RevokeUserPendingExpires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:revoke-user-pending-expires';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //;
        logger('app:revoke-user-pending-expires');
        $ups = UserPending::where('expires_at','<=',now())->get();
        foreach($ups as $up)
        {
            $up->delete();
        }

    }
}
