<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model 
{

    protected $table = 'pages';
    public $timestamps = true;
    // protected $fillable = array('name', 'desc', 'ulr');
    protected $guarded = ['id'];


}