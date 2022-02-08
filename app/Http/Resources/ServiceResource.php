<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'desc'                  => (string) $this->desc,
            'duration'              => (string) $this->duration,
            'price'                 => (float) $this->price,
            'offer_price'           => (float) $this->offer_price,
            'image'                 => (string) url('' . $this->image),
            'user_id'               => (int)   $this->user_id,
        ];
    }
}
