<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class VentaFormRequest extends Request
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
            'cli_id'=>'required',
            'ven_tipocomprob'=>'required|max:20',
            'ven_seriecomprob'=>'max:7',
            'ven_numcomprob'=>'required|max:10',
            'art_id'=>'required',
            'det_v_cantidad'=>'required',
            'det_v_precioventa'=>'required',
            'det_v_descuento'=>'required',
            'ven_totalventa'=>'required'
        ];
    }
}
