<?php
    namespace App\Rotas;
    use App\Interfaces\ICustomRoute;
    use \Route;
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:22
 */
class UserRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::get('user/perfil/', [
                'as' => 'user.meu_perfil',
                'uses' => 'UserController@myProfile'
            ]);
            Route::patch('user/password/change', [
                'as' => 'user.alterar_senha',
                'uses' => 'UserController@alterarSenha',
            ]);
            
            Route::group(['middleware' => ['acl'],'is' => 'administrador', 'protect_alias'  => 'user'],function (){
                Route::post('user/password/reset', [
                    'as' => 'user.solicitar_nova_senha',
                    'uses' => 'UserController@solicitarNovaSenha'
                ]);
                Route::post('user/password/reset/change', [
                    'as' => 'user.criar_nova_senha',
                    'uses' => 'UserController@criarNovaSenha',
                ]);
                Route::post('user/alterar_imagem', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'UserController@changeImage',
                ]);
                Route::post('user/alterar_imagem_admin/{id}', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'UserController@changeImageAdmin',
                ]);

                Route::resource('user', 'UserController',[
                    'except' => ['create', 'edit']
                ]);
            });
        });
    }
}