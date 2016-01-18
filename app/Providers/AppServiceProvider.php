<?php

namespace App\Providers;

use App\Models\Users\Entities\User;
use App\Models\Users\Repositories\UserRepository;
use App\Http\Controllers\Auth\Social;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        $this->app->bind(
                'Illuminate\View\ViewServiceProvider',
                'App\Providers\JsonAwareViewProvider'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){

        /*        $this->when(Social\GoogleController::class)
                        ->needs(ObjectRepository::class)
                        ->give(function ($app){
                            EntityManager::getRepository(User::class);
                        }
                        );*/

        $this->app->bind(UserRepository::class, function ($app){
            return new UserRepository(
                    $app['em'],
                    $app['em']->getClassMetaData(User::class)
            );
        });
    }
}
