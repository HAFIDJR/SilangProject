<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('view-project', function (User $user,Project $project) {
            return $user->id === $project->user_id;
        });

        Gate::define('can-join', function (User $user,Project $project) {
            return $user->id !== $project->user_id;
        });

        Gate::define('view-task',function(User $user ,Project $project ){
            return $user->id === $project->user_id || $project->members->contains('id',$user->id);
        });
    }
}
