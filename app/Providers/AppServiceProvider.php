<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;

use DB;


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
        Schema::defaultStringLength(191);

        DB::listen(function ($query){
            //dump($query->sql);
            //dump($query->bindings);
        });
        app('view')->composer('layouts.site', function ($view) {
            $route = app('request')->route();
            if($route){
                $action = $route->getAction();

                $controller = class_basename($action['controller']);

                list($controller, $action) = explode('@', $controller);

                $view->with(compact('controller', 'action'));
            }

        });
    }
}
