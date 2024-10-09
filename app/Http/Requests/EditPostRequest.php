<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditPostRequest extends FormRequest
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
    // Fonction qui force l utilisation de titre (required)
    public function rules(): array
    {
        return [
            'titre' => 'required'
        ];
    }

    // Fonction en cas de validation et que les condition d utilisation ne sont pas respecter
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'error'=>true,
            'message'=>'Erreur de validation',
            'errorsList'=>$validator->errors()
        ]));
    }

    // Fonction pour personnaliser ton message d erreur
    public function messages() {
        return [
            'titre.required'=>'Un titre doit être fourni'
        ];
    }
}
