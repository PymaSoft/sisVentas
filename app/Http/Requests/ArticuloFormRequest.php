<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class ArticuloFormRequest extends Request
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
            'cat_id'=>'required',
            'art_codigo'=>'required|max:50',
            'art_nombre'=>'required|max:100',
            'art_stock'=>'required|numeric',
            'art_descripcion'=>'max:512',
            'art_imagen'=>'mimes:jpeg,bmp,png'
        ];
    }
}
