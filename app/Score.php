<?php
/**
 * Created by PhpStorm.
 * User: Damian
 * Date: 19.04.2016
 * Time: 19:22
 */

namespace app;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';
    public $timestamps = false;
}