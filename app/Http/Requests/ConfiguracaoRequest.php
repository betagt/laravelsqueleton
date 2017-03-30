<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfiguracaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'titulo'              => 'string|max:255|required',
            'email'               => 'string|email|required',
            'url_site'            => 'string|url|required',
            'telefone'            => 'string|max:255|required',
            'horario_atendimento' => 'string|max:255|required',
            'endereco'            => 'string|max:255|required',
            'rodape'              => 'string|max:255|required',
            'facebook'            => 'string|nullable|max:255',
            'twitter'             => 'string|nullable|max:255',
            'google_plus'         => 'string|nullable|max:255',
            'youtube'             => 'string|nullable|max:255',
            'instagram'           => 'string|nullable|max:255',
            'palavra_chave'       => 'string|nullable|max:255',
            'descricao_site'      => 'string|nullable|max:255',
            'og_tipo_app'         => 'string|nullable|max:255',
            'og_titulo_site'      => 'string|nullable|max:255',
            'od_url_site'         => 'string|nullable|url',
            'od_autor_site'       => 'string|nullable|max:255',
            'facebook_id'         => 'string|nullable|max:255',
            'token'               => 'string|nullable|max:255',
            'analytcs_code'       => 'string|nullable'
        ];
    }
}
