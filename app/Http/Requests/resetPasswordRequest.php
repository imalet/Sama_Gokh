<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class resetPasswordRequest extends FormRequest
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
            'email' => 'sometimes|email',
            'telephone'=> ['required', 'regex:/^\+221(77|78|76|70)\d{7}$/'],
            'password'=> 'required|min:8'
        ];
    }
    public function messages()
    {
        return [
            
            // 'username.required' => "Le nom d'utilisateur  est requis",
            // 'username.unique' => "Ce nom d'utilisateur existe déjà",
            'telephone.regex' => "Ce numéro est invalide",
            'password.required' => "Le mot de passe de l'utilisateur  est requis",
            'password.min' => "Le mot de passe doit au moins avoir 8 caractères"
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
