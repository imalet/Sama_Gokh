<?php

namespace App\Http\Requests\Vote;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjouterVoteRequest extends FormRequest
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
            'user_id' => 'exists:users,id|exists:votes, user_id',
            'scrutin' => ['required', 'regex:/^(pour|contre)$/i'],
            'projet_id' => 'exists:projets,id',
            // 'date_de_cloture' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Le champ utilisateur est requis.',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas.',
            'user_id.exists'=> 'L\'utilisateur a déjà voté.',
            'statut.required' => 'Le champ statut est requis.',
            'statut.regex' => 'Le statut doit être "pour" ou "contre".',
            'projet_id.required' => 'Le champ projet est requis.',
            'projet_id.exists' => 'Le projet spécifié n\'existe pas.',
            'date_de_cloture.required' => 'Le champ date de clôture est requis.',
            'date_de_cloture.date' => 'La date de clôture doit être une date valide.',

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
