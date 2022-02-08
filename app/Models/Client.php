<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function neighborhood()
    {
        return $this->belongsTo('App\Models\Neighborhood', 'neighborhood_id');
    }
}
