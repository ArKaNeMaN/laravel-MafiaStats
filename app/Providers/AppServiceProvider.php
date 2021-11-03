<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Dashboard::useModel(\Orchid\Platform\Models\User::class, \App\Models\User::class);

        $this->registerFieldsMacro();
    }


    protected function registerFieldsMacro(){
        TD::macro('button', function($routeName, $routeParams = null, $routeAbsolute = true) {
            $col = $this->column;

            $this->render(function($data) use($col, $routeName, $routeParams, $routeAbsolute) {
                return Link::make($data->$col)
                    ->href(route($routeName, $routeParams ?: $data, $routeAbsolute));
            });

            return $this;
        });
    }
}
