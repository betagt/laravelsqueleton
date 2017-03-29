<?php


namespace App\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormaPgtoCriteria
 * @package namespace App\Criteria;
 */
class RotaAcessoCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'rota_acessos.text' =>'like',
        'rota_acessos.rota'=>'like',
        'rota_acessos.parent_id'=>'=',
        'rota_acessos.disabled'=>'=',
        'rota_acessos.is_menu'=>'=',
    ];
}