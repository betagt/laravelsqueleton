<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Criteria\OrderCriteria;
use App\Criteria\RoleCriteria;
use App\Http\Controllers\BaseController;
use App\Http\Requests\RoleRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\RoleService;
use Validator;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários na API qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class RoleController extends BaseController
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleService
     */
    private $roleService;

    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository,
        UserRepository $userRepository,
        RoleService $roleService)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
        parent::__construct($roleRepository, RoleCriteria::class);
    }


    public function getValidator($id = null)
    {
        $this->validator = (new RoleRequest())->rules();
        return $this->validator;
    }

    /**
     * Regra do Usuário
     *
     * Busca todos os perfis do usuário
     * @param $id
     * @return array
     */
    public function roleByUser($id){
        try{
            return $this->userRepository->getRoles($id);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }


    /**
     *  Remover Regra
     *
     * Revogar todas as regras
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function revokeRole(Request $request){
        $data = $request->all();
        Validator::make($data, [
            'role_id' => [
                'required',
                'exists:roles,id',
                'integer'
            ],
            'user_id' => [
                'required',
                'exists:users,id',
                'integer'
            ],
        ])->validate();
        try{
            return $this->userRepository->revokeRole($data['user_id'],$data['role_id']);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }

    /**
     * Remover Todas Regras Usuário
     *
     * Revogar todas as regras de um usuário
     * @param $id
     * @return mixed
     */
    public function revokeAllRoles($id){
        try{
            return $this->userRepository->revokeAllRoles($id);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }

    /**
     * Sicronizar Permissões p/ Regra
     *
     * Sicronizar todas as permissões para um role(perfil)
     * @param Request $request
     * @return mixed|void
     */
    public function syncPermissions(Request $request){
        $data = $request->all();
        $rules = [
            'role_id' => [
                'required',
                'exists:roles,id',
                'integer'
            ],
            'permissions'=>'required|array'
        ];

        $permissions = $request->get('permissions',[]);
        foreach ($permissions as $key => $val){
            $rules["permissions.$key"] = [
                'required',
                'exists:permissions,id',
                'integer'
            ];
        }

        Validator::make($data, $rules)->validate();

        try{
            return $this->roleRepository->syncPermissions($data['role_id'],$data['permissions']);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }

    /**
     * Sicronizar Regra
     *
     * Sicronizar regras
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function syncRoles(Request $request){
        $data = $request->all();
        $rules = [
            'user_id' => [
                'required',
                'exists:users,id',
                'integer'
            ],
            'rules'=>'required|array'
        ];

        $permissions = $request->get('rules',[]);
        foreach ($permissions as $key => $val){
            $rules["rules.$key"] = [
                'required',
                'exists:rules,id',
                'integer'
            ];
        }

        Validator::make($data, $rules)->validate();
        try{
            return $this->userRepository->syncRoles($data['user_id'],$data['rules']);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }


    /**
     * Associar Regra ao Usuário
     *
     * Endpoint para associar um regra a um usuário
     *
     */
    public function assocRuleUser(Request $request){
        $data = $request->all();
        Validator::make($data, [
            'role_id' => [
                'required',
                'exists:roles,id',
                'integer',
                Rule::unique('role_user')->where(function ($query) use ($data){
                    $query->where('user_id', $data['user_id']);
                    $query->where('role_id', $data['role_id']);
                }),
            ],
            'user_id' => [
                'required',
                'exists:users,id',
                'integer',
                Rule::unique('role_user')->where(function ($query) use ($data){
                    $query->where('user_id', $data['user_id']);
                    $query->where('role_id', $data['role_id']);
                }),
            ],
        ])->validate();
        try{
            $this->roleService->createAssoc($data);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }
}
