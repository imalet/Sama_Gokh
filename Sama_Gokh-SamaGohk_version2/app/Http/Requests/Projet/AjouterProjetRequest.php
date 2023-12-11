<?php

namespace App\Http\Requests\Projet;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjouterProjetRequest extends FormRequest
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
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required',
            'couts' => 'required|numeric',
            'delai' => 'required|date',
            // 'etat' => ['required','boolean'],
            // 'type_projet_id' => 'required|exists:type_projets,id',
            // 'etat_projet_id' => 'required|exists:etat_projets,id',
        ];
    }

    public function messages()
    {
        return [
            'titre.required' => 'Le champ titre est requis.',
            'titre.string' => 'Le champ titre doit être une chaîne de caractères.',
            'titre.max' => 'Le champ titre ne doit pas dépasser :max caractères.',
            'description.required' => 'Le champ description est requis.',
            'description.string' => 'Le champ description doit être une chaîne de caractères.',
            'image.required' => 'Le champ image est requis.',
            'image.string' => 'Le champ image doit être une chaîne de caractères.',
            'couts.required' => 'Le champ couts est requis.',
            'couts.numeric' => 'Le champ couts doit être un nombre.',
            'delai.required' => 'Le champ delai est requis.',
            'delai.date' => 'Le champ delai doit être une date valide.',
            'etat.required' => 'Le champ etat est requis.',
            'etat.boolean' => 'Le champ etat doit être un booléen.',
            'type_projet_id.required' => 'Le champ type_projet_id est requis.',
            'type_projet_id.exists' => 'Le type de projet spécifié n\'existe pas.',
            'etat_projet_id.required' => 'Le champ etat_projet_id est requis.',
            'etat_projet_id.exists' => 'L\'état du projet spécifié n\'existe pas.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Si la validation échoue, vous pouvez accéder aux erreurs
        $errors = $validator->errors()->toArray();

        // Retournez les erreurs dans la réponse JSON
        throw new HttpResponseException(response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
