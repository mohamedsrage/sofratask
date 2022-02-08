<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    protected $table = 'favourites';
    public $timestamps = true;
    // protected $fillable = array('post_id', 'client_id');
    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
