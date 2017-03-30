<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1','middleware' => ['cors']], function () {
    //'is' => 'administrador|moderador,or'
    \App\Rotas\UserRoute::run();
    \App\Rotas\RoleRoute::run();
    \App\Rotas\PermissionRoute::run();
    \App\Rotas\ClienteRoute::run();
    \App\Rotas\RotaAcessoRoute::run();
    \App\Rotas\ConfiguracaoRoute::run();
});

