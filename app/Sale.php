<?php
/**
 * Created by PhpStorm.
 * User: Damian
 * Date: 10.04.2016
 * Time: 15:56
 */

namespace app;

use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{
    protected $table = 'sale';

    public function user()
    {
        return $this->belongsTo('App\User', 'userID'); //zamówienie należy do użytkownika
    }

    public function game()
    {
        return $this->belongsTo('App\Game', 'appid');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'id', 'saleID');
    }


}