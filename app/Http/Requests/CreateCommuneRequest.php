<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCommuneRequest extends FormRequest
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
            'nom' => 'required|max:50',
            'nombreCitoyen' => 'required|integer',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ville_id' => 'required|exists:villes,id',
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
            'nom.required' => 'Le nom de la commune est obligatoire, veuillez le renseigner.',
            'nom.max' => 'Le nom de la commune ne peut pas dépasser 50 caractères.',
            'nombreCitoyen.required' => 'Le nombre de citoyens est obligatoire, veuillez le renseigner.',
            'nombreCitoyen.integer' => 'Le nombre de citoyens doit être un nombre entier.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'Le fichier image doit être sous format :jpeg, :png, :jpg, :gif ou :svg.',
            'image.max' => 'La taille maximale de l\'image est de 2048 kilo-octets.',
            'ville_id.required' => 'La ville associée à la commune est obligatoire, veuillez la trouver.',
            'ville_id.exists' => 'La ville associée à la commune n\'existe pas.',
        ];
    }
}
