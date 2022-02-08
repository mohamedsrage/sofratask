<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model 
{

    protected $table = 'rates';
    public $timestamps = true;
    // protected $fillable = array('client_id', 'resturant_id', 'desc', 'order_id', 'rate');
    protected $guarded = [];


    public function Client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function Resturant()
    {
        return $this->belongsTo('App\Models\Resturant', 'resturant_id');
    }

}