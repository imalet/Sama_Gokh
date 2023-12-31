<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UserRegisterRequest extends FormRequest
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
            'nom' => 'required',
            'prenom' => 'required',
            'age'=> 'required',
            'email' => 'required|email',
            'password'=> 'required',
            'telephone'=> 'required',
            'username' => 'required',
            'CNI' => 'required',
             'sexe' => 'required'

        ];
    }
    public function messages()
    {
        return [
            'nom.required' => "Le nom doit être renseigné",
            'prenom.required' => "Le prénom doit être renseigné",
            'age.required' => "L'age doit être renseigné",
            'telephone.required' => "Votre numéro doit être renseigné",
            'email.email' => "L'adresse email n'est pas valide",
            // 'email.exists'=> "L'email n'existe pas !",
            'password.required' => "Le mot de passe est requis",
            'username.required' => "Le nom d'utilisateur  est requis",
            // 'username.unique' => "Ce nom d'utilisateur existe déjà",
            'CNI.required' => "Le CNI  est requis",
            // 'CNI.unique' => "Ce CNI existe déjà",
            'sexe.required' => "veuillez renseigner votre sexe"
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
