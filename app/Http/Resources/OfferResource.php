<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'start_date'            => (float) $this->start_date,
            'end_date'              => (float) $this->end_date,
            'image'                 => (string) url('' . $this->image),
            'user_id'               => (int)   $this->user_id,
            'name'                  => is_null($this->user) ? '' : (string) $this->user->name,
            'phone'                 => is_null($this->user) ? '' : (string) $this->user->phone,
            'email'                 => is_null($this->user) ? '' : (string) $this->user->email,
            'Minimum_order'         => is_null($this->user) ? '' : (string) $this->user->Minimum_order,
            'Delivery_Charge'       => is_null($this->user) ? '' : (string) $this->user->Delivery_Charge,
            'contact_information'   => is_null($this->user) ? '' : (string) $this->user->contact_information,
            'whats_app'             => is_null($this->user) ? '' : (string) $this->user->whats_app,
            'avatar'                => is_null($this->user) ? '' : (string) url('' . $this->user->avatar),
            'image'                 => is_null($this->user) ? '' : (string) url('' . $this->user->image),
        ];
    }
}
