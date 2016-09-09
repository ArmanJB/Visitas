<?php

namespace visitas\Http\Requests;

use visitas\Http\Requests\Request;

class OficialRequest extends Request
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
            'nombres' => 'required|min:3',
            'apellidos' => 'required|min:3',
            'id_area' => 'required'
        ];
    }
}
