<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessClient;
use App\Models\Client;
use App\Presenters\ClientPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ClientRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
    /**
     * Specify Model class name
     *
     * @return Client
     */
    public function model()
    {
        return Client::class;
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return ClientPresenter::class;
    }


    public function findActive($id)
    {
        return $this->parserResult($this->model->where('user_id', $id)
            ->orderBy('name', 'desc')->get());
    }

    public function forUser($userId)
    {
        return $this->parserResult($this->model->where('user_id', $userId)
            ->orderBy('name', 'desc')->get());
    }

    public function activeForUser($userId)
    {
        return $this->parserResult($this->model
            ->where('user_id', $userId)
            ->where('revoke',false)
            ->orderBy('name', 'desc')->get());
    }

    public function personalAccessClient()
    {
        if (Passport::$personalAccessClient) {
            return $this->model->find(Passport::$personalAccessClient);
        } else {
            return PersonalAccessClient::orderBy('id', 'desc')->first()->client;
        }
    }

    public function createPersonalAccessClient($userId, $name, $redirect, $personalAccess = false, $password = false)
    {
        $data = [
            'user_id' => $userId,
            'name' => $name,
            'secret' => str_random(40),
            'redirect' => $redirect,
            'personal_access_client' => $personalAccess,
            'password_client' => $password,
            'revoked' => false,
        ];
        return $this->create($data);
    }

    public function createPasswordGrantClient($userId, $name, $redirect)
    {
        return $this->create($userId, $name, $redirect, false, true);
    }

    public function regenerateSecret($clientId)
    {
        $client = $this->model->find($clientId);

        if(!$client)
            throw new ModelNotFoundException(trans('errors.sql_state.registre_not_found'));
        $client->forceFill([
            'secret' => str_random(40),
        ])->save();
        return $this->parserResult($client);
    }

    public function revoked($id)
    {
        return $this->model->where('id', $id)
            ->where('revoked', true)->exists();
    }

    public function revogarTokens($clientId)
    {
        $client = $this->model->find($clientId);
        if(!$client)
            throw new ModelNotFoundException(trans('errors.sql_state.registre_not_found'));

        $client->tokens()->update(['revoked' => true]);
        $client->forceFill(['revoked' => true])->save();
    }

}
