<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'username.required' => __('Unesite korisniko ime'),
            'password.required' => __('Unesite lozinku')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = ['message' => $validator->errors()->first()];
        throw new HttpResponseException(response()->json($message, 422));
    }
}
