<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    public $timestamps = true;
    // protected $fillable = array('title', 'content');
    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTO('App\Models\Client');
    }
    public function donationRequest()
    {
        return $this->belongsToMany('App\Models\DonationRequests');
    }

}
