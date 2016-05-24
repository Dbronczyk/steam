<?php

namespace app;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    public $timestamps = false;
    protected $table = 'order';

    public function sale()
    {
        return $this->belongsTo('App\Sale', 'saleID');
    }

    public function seller()
    {
        return $this->belongsTo('App\User', 'sellerID'); //jeden użytkownik ma wiele ofert sprzedaży
    }

    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyerID'); //jeden użytkownik ma wiele ofert sprzedaży
    }

    public function remover()
    {
        return $this->belongsTo('App\User', 'remove'); //jeden użytkownik ma wiele ofert sprzedaży
    }


}