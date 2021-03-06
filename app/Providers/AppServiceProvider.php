<?php

namespace App\Providers;

use App\Mappings\HasAnnotatedPermissions;
use App\Models\Acl\Entities\Role;
use App\Models\Acl\Repositories\RoleRepository;

use App\Models\Users\Entities\User;
use App\Models\Users\Repositories\UserRepository;

use App\Models\Orders\Entities\Order;
use App\Models\Orders\Repositories\OrderRepository;

use App\Models\Invitations\Entities\Invitation;
use App\Models\Invitations\Repositories\InvitationRepository;

use App\Http\Controllers\Auth\Social;

use Illuminate\Support\ServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;


class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        AnnotationRegistry::registerFile(__DIR__ . '/../Mappings/HasAnnotatedPermissions.php');

        $this->app->bind(
                'Illuminate\View\ViewServiceProvider',
                'App\Providers\JsonAwareViewProvider'
        );
        $this->app->bind(
                'LaravelDoctrine\ACL\Permissions\PermissionManager',
                'App\Models\Acl\Permissions\PermissionManager'
        );
        $this->app->bind(
                'LaravelDoctrine\ACL\Mappings\Subscribers\HasPermissionsSubscriber',
                'App\Mappings\Subscribers\HasPermissionsSubscriber'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */

    public function register(){
        $this->app->bind(UserRepository::class, function ($app){
            return new UserRepository(
                    $app['em'],
                    $app['em']->getClassMetaData(User::class)
            );
        });

        $this->app->bind(OrderRepository::class, function ($app){
            return new OrderRepository(
                    $app['em'],
                    $app['em']->getClassMetaData(Order::class)
            );
        });

        $this->app->bind(RoleRepository::class, function ($app){
            return new RoleRepository(
                    $app['em'],
                    $app['em']->getClassMetaData(Role::class)
            );
        });

        $this->app->bind(InvitationRepository::class, function ($app){
            return new InvitationRepository(
                    $app['em'],
                    $app['em']->getClassMetaData(Invitation::class)
            );
        });
    }
}
