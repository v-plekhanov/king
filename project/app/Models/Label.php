<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    protected $fillable = ['label'];

    public $timestamps = false;

    /**
     * @return BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task', 'label_task', 'label_id', 'task_id');
    }
}
