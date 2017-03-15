<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;

/**
 * Class PermissionCriteria
 * @package namespace Portal\Criteria;
 */
class PermissionCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'permissions.id'        =>'=',
        'permissions.name'      =>'like',
        'permissions.created_at'=>'between',
        'permissions.updated_at'=>'between',
    ];
}
