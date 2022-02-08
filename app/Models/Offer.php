<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    // protected $fillable = array('name', 'image', 'desc', 'user_id', 'start_date', 'end_date');
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo('App\Models\Resturant', 'user_id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'user_id');
    }

}