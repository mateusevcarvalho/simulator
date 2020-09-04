<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimulateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'valor_emprestimo'  => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            'instituicoes'      => 'nullable|array',
            'parcela'           => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
            'valor_emprestimo.regex' => 'O campo valor_emprestimo deve ser float'
        ];
    }
}
