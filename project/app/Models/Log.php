<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Log extends Model
{
    protected $collection = 'log';
    protected $connection = 'mongodb';
}
