<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResturantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id'                    => (int)    $this->id,
            'name'                  => (string) $this->name,
            'phone'                 => (string) $this->phone,
            'email'                 => (string) $this->email,
            'Minimum_order'         => (string) $this->Minimum_order,
            'Delivery_Charge'       => (string) $this->Delivery_Charge,
            'contact_information'   => (string) $this->contact_information,
            'whats_app'             => (string) $this->whats_app,
            'avatar'                => (string) url('' . $this->avatar),
            'image'                 => (string) url('' . $this->image),
            'api_token'             => (string) $this->api_token,
            'is_active'             => (bool)   $this->active,
            'avalible'              => (bool)   $this->avalible,
            'city_id'               => (string) $this->city_id,
            'city_name'             => is_null($this->city) ? '' : (string)   $this->city->name,
            'neighborhood_id'       => (string)  $this->neighborhood_id,
            'neighborhood_name'     => is_null($this->neighborhood) ? '' : (string)   $this->neighborhood->name,
            'category_id'           => (string)  $this->category_id,
            'category_name'         => is_null($this->category) ? '' : (string)   $this->category->name,
        ];
    }
}
