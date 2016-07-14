<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 14/07/16
 * Time: 02:09
 */

namespace App\Core\Providers;


use App\Domains\Users\Repositories\UserRepositoryEloquent;
use App\Domains\Users\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepositoryEloquent::class);
    }

    /**
     * Register any application services
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

}