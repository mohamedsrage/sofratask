<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model
{
    use HasFactory, SearchableTrait;
    protected $guarded = ['id'];

    protected $searchable = [
       
        'columns' => [
            'tags.name' => 10,
            
        ],
    ];

    public function status()
    {
        return $this->status ? 'Activ' : 'Inactive'; 
    }

    public function products() : MorphToMany
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }


}
