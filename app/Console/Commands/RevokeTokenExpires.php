<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class RevokeTokenExpires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:revoke-token-expires';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa các token đã hết hạn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        logger('app:revoke-token-expires');
        $users = User::all();
        foreach ($users as $user) {
            $tokens = $user->tokens()->where('expires_at', '<=', now())->get();
            foreach ($tokens as $token) {
                $token->delete();
            }
        }
    }
}
