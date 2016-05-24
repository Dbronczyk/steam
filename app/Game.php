<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'game';
    public $timestamps = false;
    protected $primaryKey = 'appid';
    
    public function sale()
    {
        return $this->hasMany('App\Sale', 'appid');
    }
}