<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 30/12/2016
 * Time: 10:44
 */

namespace App\Providers;


use App\Repositories\ConfiguracaoRepository;
use App\Repositories\ConfiguracaoRepositoryEloquent;
use App\Repositories\PermissionRepository;
use App\Repositories\PermissionRepositoryEloquent;
use App\Repositories\RoleRepository;
use App\Repositories\RoleRepositoryEloquent;
use App\Repositories\RotaAcessoRepository;
use App\Repositories\RotaAcessoRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\ClientRepository;
use App\Repositories\ClientRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepository::class,
            UserRepositoryEloquent::class
        );
        $this->app->bind(
            RoleRepository::class,
            RoleRepositoryEloquent::class
        );
        $this->app->bind(
            PermissionRepository::class,
            PermissionRepositoryEloquent::class
        );

        $this->app->bind(
            ClientRepository::class,
            ClientRepositoryEloquent::class
        );

        $this->app->bind(
            RotaAcessoRepository::class,
            RotaAcessoRepositoryEloquent::class
        );
        $this->app->bind(
            ConfiguracaoRepository::class,
            ConfiguracaoRepositoryEloquent::class
        );

    }
}