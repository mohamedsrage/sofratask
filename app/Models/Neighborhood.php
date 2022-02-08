<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Neighborhood extends Model 
{

    protected $table = 'neighborhoods';
    public $timestamps = true;
    // protected $fillable = array('name', 'city_id');
    protected $guarded = ['id'];

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }
    
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}