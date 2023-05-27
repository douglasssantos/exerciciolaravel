<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|min:6',
            'contact' => "required|numeric|digits:9|unique:contacts",
            'email' => 'required|email:rfc,dns|unique:contacts'
        ];
    }

    public function messages()
    {
        return [
          'name.required' => "O nome é obrigatório.",
          'name.min' => "O nome precisa ter no minimo 6 caracteres.",
          'contact.required' => "O contato é obrigatório.",
          'contact.numeric' => "Permitido somente numeros.",
          'contact.digits' => "O contato precisa ter 9 digitos.",
          'contact.unique' => "Já existe um contato com este numero.",
          'email.required' => "O e-mail é obrigatório.",
          'email.email' => "E-mail inválido.",
          'email.unique' => "Já existe um contato com este e-mail.",
        ];
    }
}
