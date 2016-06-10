<?php

namespace visitas\Http\Requests;

use visitas\Http\Requests\Request;

class DetalleRequest extends Request
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
            'id_visita' => 'required',
            'id_motivo' => 'required'
        ];
    }
}
