<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/01/2017
 * Time: 13:50
 */

namespace App\Services;


use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class PermissionService
{
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    const defaltSlug = [
        "store",
        "show",
        "update",
        "delete",
        "index"
    ];
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PermissionRepository $permissionRepository, RoleRepository $roleRepository,UserRepository $userRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $roleId
     * @param int $permissionId
     * @return mixed
     */
    public function assocPermissionRole(int $roleId, $permUser){
        return $this->roleRepository->assignPermission($roleId, $permUser);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function assocPermissionUser($data){
        $rs = $this->userRepository->addPermission($data['user_id'],$data['name'],$data['slug']);
        if( !$rs){
            abort(422,'Alias ja esite');
        }
        return $rs;
    }
}