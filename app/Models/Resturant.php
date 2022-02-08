<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function services()
    {
        return $this->hasMany('App\Models\Service', 'user_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function neighborhood()
    {
        return $this->belongsTo('App\Models\Neighborhood', 'neighborhood_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
