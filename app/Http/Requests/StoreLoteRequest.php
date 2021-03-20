<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoteRequest extends FormRequest
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
            'numero_lote'       => 'required',
            'fabricante'        => 'required',
            'numero_vacinas'    => 'required',
            'segunda_dose'      => '',
            'data_fabricacao'   => 'required',
            'data_validade'     => 'required',
        ];
    }
}
