<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class DistribuicaoRequest extends FormRequest
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
        // dd($this->request->all());
        return [
            'posto.*' => 'gte:0|integer'
        ];
    }

    public function messages()
    {
        return [
            'posto.*.gte'       => 'O número digitado deve ser maior ou igual a 0.',
            'posto.*.integer' => 'O número digitado deve ser um inteiro.',
        ];
    }
}
