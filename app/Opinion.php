<?php
/**
 * Created by PhpStorm.
 * User: Damian
 * Date: 19.04.2016
 * Time: 19:23
 */

namespace app;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $table = 'opinion';
    public $timestamps = false;

    public function rev()
    {
        return $this->belongsTo('App\User', 'reviewer');
    }


}