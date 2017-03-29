<?php

namespace App\Presenters;

use App\Transformers\RotaAcessoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RotaAcessoPresenter
 *
 * @package namespace App\Presenters;
 */
class RotaAcessoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RotaAcessoTransformer();
    }
}
