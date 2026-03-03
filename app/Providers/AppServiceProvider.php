<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event; 
use Illuminate\Auth\Events\Authenticated; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Gate;

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
        // lorsque que Laravel trouve un utilisateur avec connexion ou changement de page
        Event::listen(Authenticated::class, function ($event) {
            
            if ($event->user->banned_at) {
                
                Auth::logout(); 
               
                abort(403, "Votre compte a été banni par l'administrateur.");
            }
        });

        Gate::define('admin-only', function ($user) {
            return $user->role_type === 'admin';
        });
    }
}
