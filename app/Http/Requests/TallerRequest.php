<?php

namespace visitas\Http\Requests;

use visitas\Http\Requests\Request;

class TallerRequest extends Request
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
            'duracion' => 'required',
            'cant_mujeres' => 'required',
            'cant_hombres' => 'required',
            'observaciones' => 'required|min:5',
            'id_lugar' => 'required',
            'id_actividad' => 'required'
        ];
    }
}
