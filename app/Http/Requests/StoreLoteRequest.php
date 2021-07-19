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
            'dose_unica'      => '',
            'inicio_periodo'    => 'required|integer|',
            'fim_periodo'       => 'required|gte:inicio_periodo|integer',
            'data_fabricacao'   => 'nullable|before:data_validade',
            'data_validade'     => 'nullable|after:data_fabricacao',
        ];
    }
}
