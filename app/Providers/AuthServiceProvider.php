<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Article;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();
        Gate::define('create-article',function(User $user){
            return $user->roles()->where('roles.role_id', 1)->exists();
        });
        Gate::define('delete-update-article',function(User $user,Article $article)
        {
            if($user->roles()->where('roles.role_id',2)->exists() || $user->user_id == $article->user_id)
            {
                
                return true;
            }
            // dd($article->user_id,$user->user_id);
            return false;
        });
        Gate::define('publish-update',function(User $user, Article $article){
            return $user->roles()->where('roles.role_id',[1,2])->exists();
        });
        Gate::define('accept-update',function(User $user, Article $article){
            return $user->roles()->where('roles.role_id',2)->exists();
        });
    }
}
