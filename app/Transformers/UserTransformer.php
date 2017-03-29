<?php

namespace Portal\Transformers;

use App\Models\Telefone;
use App\Models\User;

/**
 * Class UserTransformer
 * @package namespace App\Transformers;
 */
class UserTransformer extends BaseTransformer
{
    public $availableIncludes = ['permissions', 'roles', 'endereco','telefones'];
    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'                => (int) $model->id,
            'name'              => (string) $model->name,
            'email'             => (string) $model->email,
            'email_alternativo' => (string) $model->email_alternativo,
            'sexo_label'        => (string) User::$_SEXO[$model->sexo],
            'sexo'              => (int) $model->sexo,
            'imagem'            => (string) ($model->imagem)?url('arquivos/img/user/'.$model->imagem):url('arquivos/img/sem_imagem/null.gif'),
            'status'            => (string) $model->status,
            'chk_newsletter'    => (boolean) $model->chk_newsletter,
            'excluido'          => (boolean) $model->trashed(),
            'created_at'        => $model->created_at,
            'updated_at'        => $model->updated_at
        ];
    }

    public function includePermissions(User $model)
    {
        if (!$model->permissions)
        {
            return null;
        }
        return $this->collection($model->permissions, new PermissionTransformer());
    }

    public function includeRoles(User $model)
    {
        if (!$model->return_roles)
        {
            return null;
        }
        return $this->collection($model->return_roles, new RoleTransformer());
    }

    public function includeTelefones(User $model){
        if (!$model->telefones)
        {
            return null;
        }
        return $this->collection($model->telefones, new TelefoneTransformer());
    }

    public function includeEndereco(User $model){
        if (!$model->endereco)
        {
            return null;
        }
        return $this->item($model->endereco, new EnderecoTransformer());
    }
}
