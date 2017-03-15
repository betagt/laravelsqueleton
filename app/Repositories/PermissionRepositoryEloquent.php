<?php

namespace Portal\Repositories;

use Portal\Models\Permission;
use Portal\Presenters\PermissionPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PermissionRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
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
        return PermissionPresenter::class; 
    }
}
