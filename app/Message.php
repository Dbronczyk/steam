<?php

namespace app;

use Illuminate\Database\Eloquent\Model;


class Message extends Model
{

    protected $table = 'message';
    public $timestamps = false;


    public function conversation()
    {
        return $this->belongsTo('App\Conversation', 'conversationID'); //jeden użytkownik ma wiele ofert sprzedaży
    }

}