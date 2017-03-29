<?php

namespace App\Repositories;

use App\Models\Client;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ClientRepository
 * @package namespace App\Repositories;
 */
interface ClientRepository extends RepositoryInterface
{
    public function findActive($id);

    public function forUser($userId);

    public function activeForUser($userId);

    public function personalAccessClient();

    public function createPersonalAccessClient($userId, $name, $redirect);

    public function createPasswordGrantClient($userId, $name, $redirect);

    public function regenerateSecret($clientId);

    public function revoked($id);

    public function revogarTokens($clientId);
}
