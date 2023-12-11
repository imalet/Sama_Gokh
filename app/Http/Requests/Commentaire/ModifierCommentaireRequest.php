<?php

namespace App\Http\Requests\Commentaire;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;
class ModifierCommentaireRequest extends FormRequest
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
            'annonce_id' => 'exists:annonces,id',
            'contenu' => 'required|string',
            'user_id' => 'exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'annonce_id.required' => 'Le champ annonce_id est requis.',
            'annonce_id.exists' => 'L\'annonce spécifiée n\'existe pas.',
            'contenu.required' => 'Le champ contenu est requis.',
            'contenu.string' => 'Le champ contenu doit être une chaîne de caractères.',
            'user_id.required' => 'Le champ user_id est requis.',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas.'
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

