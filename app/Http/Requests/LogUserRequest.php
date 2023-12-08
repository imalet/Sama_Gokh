<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class LogUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|max:255',
            'password'=> 'required|min:8'
        ];
    }
    public function messages()
    {
        return [
            
            'username.required' => "Le nom d'utilisateur  est requis",
            'username.max' => "Ce nom d'utilisateur est trop long",
            'password.required' => "Le mot de passe de l'utilisateur  est requis",
            'password.min' => "Le mot de passe doit contenir plus de 8 caractères"
        ];
    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'succes' => false,
            'status_code' => 422,
            'error' => true,
            'message' => 'Erreur de validation',
            'errorsList' => $validator->errors()
        ]));
    }
}
