<?php


namespace App\Services;


use BetaGT\UserAclManager\Models\User;
use BetaGT\UserAclManager\Models\Role;
use BetaGT\UserAclManager\RoleRepository;

class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function createAssoc($data){
        $user = User::find($data['user_id']);
        return $user->assignRole(Role::find($data['role_id']));
    }
}