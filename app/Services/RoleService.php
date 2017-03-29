<?php


namespace App\Services;


use App\Models\Role;
use App\Repositories\RoleRepository;

class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function createAssoc($data){
        $user = \App\Models\User::find($data['user_id']);
        return $user->assignRole(Role::find($data['role_id']));
    }
}