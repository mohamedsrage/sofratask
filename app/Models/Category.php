<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Category extends Model 
{
//Sluggable
    use HasFactory,  SearchableTrait;
    // protected $table = 'categories';
    // public $timestamps = true;
    // protected $fillable = array('name');
    protected $guarded = ['id'];
    // protected $guarded = [];



    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
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
            'categories.name' => 10,
            
        ],
    ];

    public function status()
    {
        return $this->status ? 'Activ' : 'Inactive'; 
    }

    

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');

    }

//appearedChildren
    public function appearedChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status', true);
    }

    public static function tree( $level = 1 )
    {
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereNull('parent_id')
            ->whereStatus(true)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function categroies(){
    //     return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    // }

    //  $basics = Category::whereNull('parent_id')->get();
    //  foreach($basics as $item){
    //     //$item => قسم رئيسي
    //      foreach ($item->categroies as $cat) {
    //          $cat => قسم فرعي تحته
    // }
    //  }

}