<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model 
{

    protected $table = 'carts';
    public $timestamps = true;
    // protected $fillable = array('resturant_id', 'client_id', 'section_id', 'service_id', 'total', 'delivery', 'delivery_time');
    protected $guarded = ['id'];


    public function Client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function Resturant()
    {
        return $this->belongsTo('App\Models\Resturant', 'resturant_id');
    }

    #service
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

}