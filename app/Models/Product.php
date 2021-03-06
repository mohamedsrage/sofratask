<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use HasFactory, SearchableTrait;
    protected $guarded = [];

    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'name'
    //         ]
    //     ];
    // }


    protected $searchable = [
        'columns' => [
            'products.name' => 10,
            'products.description' => 10,
        ]
    ];

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }
    public function featured()
    {
        return $this->featured ? 'Yes' : 'No';
    }

    public function category()
    {
        return $this->belongsTo(Product::class, 'category_id', 'id');
    }

    public function tags() : MorphToMany
    {
        return $this->MorphToMany(Tag::class, 'taggable');
    }


    public function firstMedia() : MorphMany
    {
        return $this->MorphMany(Media::class, 'mediable')->orderBy('file_sort', 'asc');
    }



    public function media() : MorphMany
    {
        return $this->MorphMany(Media::class, 'mediable');
    }
    
    public function reviews() : HasMany
    {
        // return $this->hasMany(ProductReview::class, 'mediable');
        return $this->hasMany(ProductReview::class);
    }
}
