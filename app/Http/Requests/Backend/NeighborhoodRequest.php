<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class NeighborhoodRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name'                  => 'required|max:255|unique:neighborhoods',
                    'status'                => 'required',

                    
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'                      => 'required|max:255|unique:neighborhoods,name,'.$this->route()->neighborhood->id,
                    'status'                    => 'required',

                    
                ];
            }
            default: break;
        }
    }
}
