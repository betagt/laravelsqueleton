<?php

namespace App\Http\Middleware;

use Closure;
use \Kodeine\Acl\Middleware\HasPermission as KodeineHasPermission;
class HasPermission extends KodeineHasPermission
{

}
