<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class PersonaFormRequest extends Request
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
            'per_nombre'=>'required|max:100',
            'per_tipodoc'=>'required|max:20',
            'per_numdoc'=>'required|max:15',
            'per_direccion'=>'max:70',
            'per_telefono'=>'max:17',
            'per_celular'=>'max:17',
            'per_email'=>'max:50'
        ];
    }
}
