<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:50', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'name' => ['string', 'min:2', 'max:100', 'nullable'],
            'school' => ['string', 'min:2', 'max:255', 'nullable'],
            'lang' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'username.requried' => __('Unesite korisničko ime'),
            'username.min' => __('Korisničko ime ne sme biti kraće od 3 karaktera'),
            'username.max' => __('Korisničko ime ne sme biti duže od 50 karaktera'),
            'username.unique' => __('Korisničko ime je zauzeto'),
            'password.required' => __('Unesite lozinku'),
            'password.confirmed' => __('Lozinke se ne podudaraju'),
            'name.min' => __('Ime ne sme biti kraće od 2 karaktera'),
            'name.max' => __('Ime ne sme biti duže od 100 karaktera'),
            'school.min' => __('Naziv škole ne sme biti kraći od 2 karaktera'),
            'school.max' => __('Naziv škole ne sme biti duži od 255 karaktera'),
            'lang.required' => __('Odaberite jezik')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = ['message' => $validator->errors()->first()];
        throw new HttpResponseException(response()->json($message, 422));
    }
}
