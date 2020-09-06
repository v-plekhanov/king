<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    protected $fillable = ['title', 'board_id', 'status'];

    /**
     * Get the task's status (backlog, development, done, review)
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        switch ($value){
            case 0:
                return 'backlog';
            case 1:
                return 'development';
            case 2:
                return 'done';
            case 3:
                return 'review';
        }
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        switch ($value){
            case 'backlog':
                $this->attributes['status'] = 0;
                break;
            case 'development':
                $this->attributes['status'] = 1;
                break;
            case 'done':
                $this->attributes['status'] = 2;
                break;
            case 'review':
                $this->attributes['status'] = 3;
                break;
        }
        $this->attributes['first_name'] = strtolower($value);
    }

    /**
     * @return BelongsTo
     */
    public function board()
    {
        return $this->belongsTo('App\Models\BoardModel', 'id', 'board_id');
    }

    /**
     * @return BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany('App\Models\Task', 'label_task', 'task_id', 'label_id');
    }

    /**
     * @return HasOne
     */
    public function image()
    {
        return $this->hasOne('App\Models\File');
    }
}
