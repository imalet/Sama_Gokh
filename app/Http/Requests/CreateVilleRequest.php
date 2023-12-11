<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateVilleRequest extends FormRequest
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
            "nom" => 'required|max:50|unique:villes|'
        ];
    }

    public function failedValidation(Validator $validator) 
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'error'   => true,
            'message'   => 'Erreur de validation',
            'errorLists'  => $validator->errors()

        ]));
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom de la ville est obligatoire, veuillez le renseigner.',
            'nom.max' => 'Le nom de la ville ne peut pas dépasser 50 caractères.',
            'nom.unique' => 'Ce nom de ville est déjà enrégistré, veuillez en choisir un autre.',
            ];
    }
}
