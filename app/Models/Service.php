<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model 
{

    protected $table = 'services';
    public $timestamps = true;
   // protected $fillable = array('image', 'name', 'desc', 'user_id', 'category_id', 'duration', 'price', 'offer_price');
   protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}