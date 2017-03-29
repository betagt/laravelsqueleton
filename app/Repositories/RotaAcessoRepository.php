<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RotaAcessoRepository
 * @package namespace App\Repositories;
 */
interface RotaAcessoRepository extends RepositoryInterface
{
    public function findByRoleIds(array $roles);

    public function findByRoleAllIds(array $roles);
}
