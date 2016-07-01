<?php

namespace visitas\Http\Requests;

use visitas\Http\Requests\Request;

class VisitaRequest extends Request
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
            'fecha' => 'required',
            'id_escuela' => 'required',
            'id_oficial' => 'required',
            'aulas' => 'required'
        ];
    }
}
