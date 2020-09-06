<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['filename', 'task_id'];

    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
