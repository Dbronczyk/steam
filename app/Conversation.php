<?php

namespace app;

use App\Message;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversation';
    public $timestamps = false;


    public function member1()
    {
        return $this->belongsTo('App\User', 'user1');
    }

    public function member2()
    {
        return $this->belongsTo('App\User', 'user2');
    }

    public function message()
    {
        return $this->hasMany('App\Message', 'conversationID');
    }


}