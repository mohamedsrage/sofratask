<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductCouponRequset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                {
                    return [
                        'code'                      => 'required|unique:product_coupons',
                        'type'                      => 'required',
                        'value'                     => 'required',
                        'description'               => 'nullable',
                        'use_time'                  => 'required|numeric',
                        'start_date'                => 'nullable|date_format:y-m-d',
                        'expire_date'               => 'required_with:start_date_format:y-m-d',
                        'greater_than'              => 'nullable|numeric',
                        'status'                    => 'required',
                    ];
                }
                case 'PUT':
                case 'PATCH':


                    {
                        return [
                            'code'                   => 'required|unique:product_coupons,code,'.$this->route()->product_coupon->id,
                            'type'                   => 'required',
                            'value'                  => 'required',
                            'description'            => 'nullable',
                            // 'description_en'         => 'nullable',
                            'use_times'              => 'required|numeric',
                            'start_date'             => 'nullable|date_format:Y-m-d',
                            'expire_date'            => 'required_with:start_date_format:Y-m-d',
                            'greater_than'           => 'nullable|numeric',
                            'status'                    => 'required',


                        ];
                    }
                    default: break;
    }
    }
}
