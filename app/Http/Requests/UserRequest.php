<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     *
     */
    public function rules()
    {
        $id = null;
        if($this->route())
            $id = $this->route()->parameter('user');

        $rules = [
            'name'                  => 'required|string|min:2',
            'email'                 => 'required|email|unique:users,email|confirmed'.(isset($id)?','.$id:''),
            'email_confirmation'    => 'required|email',
            'email_alternativo'     => 'required|email',
            'password'              => 'required|AlphaNum|min:8|Confirmed',
            'password_confirmation' => 'required',
            'sexo'                  => 'required|integer|in:1,2',
            'imagem'                => 'mimes:jpg,jpeg,bmp,png',
            'chk_newsletter'        => 'required|boolean',
        ];

        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST': {
                return $rules;
            }
            case 'PUT':
                $rules['email'] = '';
                $rules['email_confirmation'] = '';
                $rules['password'] = '';
                $rules['password_confirmation'] = '';
                $rules['chk_newsletter'] = '';
                return $rules;
            case 'PATCH':
                $this->request->remove('id');
                $this->request->remove('email');
                $rules['email'] = '';
                $rules['email_confirmation'] = '';
                $rules['password'] = '';
                $rules['password_confirmation'] = '';
                $rules['chk_newsletter'] = '';
                return $rules;
        }
        return $rules;
    }
}
