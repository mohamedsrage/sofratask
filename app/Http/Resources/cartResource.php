<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class cartResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'                 => (int)    $this->id,
            'count'              => (float)  $this->count,
            'total'              => (float)  $this->total,
            'resturant_id'       => (int)    $this->resturant_id,
            'resturant_name'     => isset($this->resturant) ? (string) $this->resturant->name : '',
            'service_id'         => (int)    $this->service_id,
            'service_title'      => isset($this->service) ? (string) $this->service->name : '',
            'first_image'        => isset($this->service) ? url('' . $this->service->image) : '',
        ];
    }
}
