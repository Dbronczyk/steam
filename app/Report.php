<?php
/**
 * Created by PhpStorm.
 * User: Damian
 * Date: 22.04.2016
 * Time: 12:14
 */

namespace app;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';
    public $timestamps = false;


    public function whoReport()
    {
        return $this->belongsTo('App\User', 'who'); //zamówienie należy do użytkownika
    }

    public function reported()
    {
        return $this->belongsTo('App\User', 'reported'); //zamówienie należy do użytkownika
    }


}