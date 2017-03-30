<?php

namespace App\Presenters;

use App\Transformers\ConfiguracaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ConfiguracaoPresenter
 *
 * @package namespace App\Presenters;
 */
class ConfiguracaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ConfiguracaoTransformer();
    }
}
