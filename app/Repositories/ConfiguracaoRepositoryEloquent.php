<?php

namespace App\Repositories;

use App\Models\Configuracao;
use App\Presenters\ConfiguracaoPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ConfiguracaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ConfiguracaoRepositoryEloquent extends BaseRepository implements ConfiguracaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Configuracao::class;
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
        return ConfiguracaoPresenter::class;
    }
}
