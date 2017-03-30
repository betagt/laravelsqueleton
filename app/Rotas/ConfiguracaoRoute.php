<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 16:28
 */

namespace App\Rotas;


use App\Interfaces\ICustomRoute;
use \Route;

class ConfiguracaoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){

            //'is' => 'administrador|moderador,or'
            Route::group(['middleware' => ['acl'],'is' => 'administrador', 'protect_alias'  => 'user'],function (){

                Route::get('configuracao', [
                    'as' => 'configuracao.index',
                    'uses' => 'ConfiguracaoController@view'
                ]);

                Route::put('configuracao', [
                    'as' => 'configuracao.put',
                    'uses' => 'ConfiguracaoController@editar'
                ]);

            });
        });

    }
}