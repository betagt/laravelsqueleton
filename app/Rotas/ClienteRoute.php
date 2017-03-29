<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:29
 */

namespace App\Rotas;
use App\Interfaces\ICustomRoute;
use \Route;

class ClienteRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::group(['middleware'=>['acl'],'is'=>'administrador','protect_alias'=>'user'],function (){
                Route::get('client/api/revoke/{id}', [
                    'as' => 'user.api_revoke',
                    'uses' => 'ClientTokenController@userRevoke',
                ]);
                Route::get('client/api/update_token/{id}', [
                    'as' => 'user.api_revoke',
                    'uses' => 'ClientTokenController@updateToken',
                ]);
                Route::resource('client', 'ClientTokenController',
                    [
                        'except' => ['create', 'edit', 'index', 'show']
                    ]);
            });
        });
    }
}