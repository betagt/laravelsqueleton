<?php

namespace App\Http\Middleware;

use Closure;
use \Kodeine\Acl\Middleware\HasPermission as KodeineHasPermission;
class HasPermission extends KodeineHasPermission
{
    protected $crud = [
        'restful'   => [
            'create' => ['POST'],
            'read'   => ['GET', 'HEAD', 'OPTIONS'],
            'view'   => ['GET', 'HEAD', 'OPTIONS'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ],
        'resource'  => [
            'create' => ['create', 'store'],
            'store'  => ['create', 'store'],
            'read'   => ['index', 'show'],
            'view'   => ['index', 'show'],
            'edit'   => ['edit', 'update'],
            'update' => ['edit', 'update'],
            'delete' => ['destroy'],
            'trasheds' => ['trasheds'],
            'excluir' => ['excluir'],
        ],
        'resources' => [
            'index','excluir', 'create', 'store',
            'show', 'edit', 'update', 'destroy'
            ,'trasheds'
        ],
    ];

}
