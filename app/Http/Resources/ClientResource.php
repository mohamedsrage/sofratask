<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'api_token'             => (string) $this->api_token,
            'avatar'                => (string) url('' . $this->avatar),
            'is_active'             => (bool)   $this->active,
            'city_id'               => (string) $this->city_id,
            'city_name'             => is_null($this->city) ? '' : (string)   $this->city->name,
            'neighborhood_id'       => (string)  $this->neighborhood_id,
            'neighborhood_name'     => is_null($this->neighborhood) ? '' : (string)   $this->neighborhood->name,
            
        ];
    }
}
