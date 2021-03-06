<?php

namespace App\Http\Requests;

class SearchPostRequest extends MainFormRequest
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
            'query' => 'required',
            'size' => 'required|integer',
            'from' => 'required|integer'
        ];
    }
}
