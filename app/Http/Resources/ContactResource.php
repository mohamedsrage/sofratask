<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'email'                 => (string) $this->email,
            'phone'                 => (string) $this->phone,
            'message'                 => (float) $this->price,
            'type'   => (string) $this->type,
            'user_id'               => (int)   $this->user_id,

        ];
    }
}
