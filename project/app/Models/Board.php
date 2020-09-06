<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{

    protected $fillable = ['name'];

    protected $with = ['tasks'];

    /**
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\TaskModel', 'board_id')->select('id', 'title', 'board_id', 'user_id');
    }
}
