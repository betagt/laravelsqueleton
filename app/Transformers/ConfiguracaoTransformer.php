<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Configuracao;

/**
 * Class ConfiguracaoTransformer
 * @package namespace App\Transformers;
 */
class ConfiguracaoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Configuracao entity
     * @param \Configuracao $model
     *
     * @return array
     */
    public function transform(Configuracao $model)
    {
        return [
            'id'                    => (int) $model->id,
            'titulo'                => $model->titulo,
            'email'                 => $model->email,
            'url_site'              => $model->url_site,
            'telefone'              => $model->telefone,
            'horario_atendimento'   => $model->horario_atendimento,
            'endereco'              => $model->endereco,
            'rodape'                => $model->rodape,
            'facebook'              => $model->facebook,
            'twitter'               => $model->twitter,
            'google_plus'           => $model->google_plus,
            'youtube'               => $model->youtube,
            'instagram'             => $model->instagram,
            'palavra_chave'         => $model->palavra_chave,
            'descricao_site'        => $model->descricao_site,
            'og_tipo_app'           => $model->og_tipo_app,
            'og_titulo_site'        => $model->og_titulo_site,
            'od_url_site'           => $model->od_url_site,
            'od_autor_site'         => $model->od_autor_site,
            'facebook_id'           => $model->facebook_id,
            'token'                 => $model->token,
            'analytcs_code'         => $model->analytcs_code,

        ];
    }



}
