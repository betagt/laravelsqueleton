<?php
    namespace Portal\Rotas;
    use Portal\Interfaces\ICustomRoute;
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
                Route::resource('user', 'UserController',[
                        'except' => ['create', 'edit']
                    ]);
                Route::post('user/alterar_imagem', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'UserController@changeImage',
                ]);
                Route::post('user/alterar_imagem_admin/{id}', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'UserController@changeImageAdmin',
                ]);
            });
        });
        Route::group(['prefix'=>'front','middleware' => ['auth:api','acl'],'is' => 'anunciante|administrador,or','namespace'=>'Api\Front'],function (){
            Route::get('user/perfil/', [
                'as' => 'user.meu_perfil',
                'uses' => 'UserController@myProfile'
            ]);
            Route::post('user/alterar_imagem', [
                'as' => 'user.alterar_imagem',
                'uses' => 'UserController@changeImage',
            ]);

            Route::patch('user/password/change', [
                'as' => 'user.alterar_senha',
                'uses' => 'UserController@alterarSenha',
            ]);

            Route::post('user/registrar', [
                'as' => 'user.registrar',
                'uses' => 'UserController@cadastrar',
            ]);

            Route::post('user/password/reset', [
                'as' => 'user.solicitar_nova_senha',
                'uses' => 'UserController@solicitarNovaSenha'
            ]);
            Route::post('user/password/reset/change', [
                'as' => 'user.criar_nova_senha',
                'uses' => 'UserController@criarNovaSenha',
            ]);

        });
    }
}