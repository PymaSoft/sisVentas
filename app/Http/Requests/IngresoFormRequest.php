<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class IngresoFormRequest extends Request
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
            'prov_id'=>'required',
            'ing_tipocomprob'=>'required|max:20',
            'ing_seriecomprob'=>'max:7',
            'ing_numcomprob'=>'required|max:10',
            'art_id'=>'required',
            'det_i_cantidad'=>'required',
            'det_i_preciocompra'=>'required',
            'det_i_precioventa'=>'required'
        ];
    }
}
