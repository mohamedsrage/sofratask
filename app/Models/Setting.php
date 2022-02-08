<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings';
    public $timestamps = true;
    // protected $fillable = array('about_app', 'phone', 'email', 'fb_link', 'tw_link', 'yoytube_link', 'ins_link');
    protected $visible = array('notificatin_setting', 'fb_link', 'tw_link', 'yoytube_link', 'ins_link');
    protected $guarded = ['id'];

}
