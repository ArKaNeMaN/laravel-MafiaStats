<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->registerModels();

        $this->routes(function () {
            Route::prefix('v1')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api-v1.php'));
        });
    }

    /**
     * @return void
     */
    protected function registerModels(){
        Route::model('player', \App\Models\Player::class);
        Route::model('game', \App\Models\Game::class);
        Route::model('gPlayer', \App\Models\GamePlayer::class);
        Route::model('gNight', \App\Models\GameNight::class);
        Route::model('gVoting', \App\Models\GameVoting::class);
        Route::model('tourney', \App\Models\Tournament::class);
        Route::model('user', \App\Models\User::class);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
