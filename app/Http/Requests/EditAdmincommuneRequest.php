<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditAdmincommuneRequest extends FormRequest
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
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'email' => 'required|email', 
            'password' => 'required|min:8',
            'telephone' => ['required', 'regex:/^\+221(77|78|76|70)\d{7}$/'], 
            // 'etat' => 'required',
            'username' => 'required',
            // 'CNI' => 'required|numeric',
           
        ];
    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'error'=>true,
            'message'=>'Erreur de validation',
            'errorsList'=>$validator->errors()
    
        ]));
    }
    public function messages(){
        return[
            'nom.required'=>'un nom doit etre fourni',
            'prenom.required'=>' prenom doit etre fourni',
            'email.required'=>'email doit etre fourni',
            'password.required'=>'password doit etre fourni',
            'telephone.required'=>'telephone doit etre fourni',
            'etat.required'=>'etat doit etre fourni',
            'username.required'=>'username doit etre fourni',
            'CNI.required'=>'CNI doit etre fourni',
            'sexe.required'=>'sexe doit etre fourni',
           
        ];
    }
}
