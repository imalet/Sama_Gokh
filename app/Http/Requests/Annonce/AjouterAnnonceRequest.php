<?php

namespace App\Http\Requests\Annonce;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjouterAnnonceRequest extends FormRequest
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
            'image' => 'required',
            'description' => 'required|string',
            // 'etat' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'titre.required' => 'Le champ titre est requis.',
            'titre.string' => 'Le champ titre doit être une chaîne de caractères.',
            'titre.max' => 'Le champ titre ne doit pas dépasser :max caractères.',
            'image.required' => 'Le champ image est requis.',
            'image.string' => 'Le champ image doit être une chaîne de caractères.',
            'description.required' => 'Le champ description est requis.',
            'description.string' => 'Le champ description doit être une chaîne de caractères.',
            'etat.required' => 'Le champ etat est requis.',
            'etat.boolean' => 'Le champ etat doit être un booléen.'
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
