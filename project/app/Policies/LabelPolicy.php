<?php

namespace App\Policies;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LabelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tasks.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the task.
     *
     * @return mixed
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the task.
     *
     * @return mixed
     */
    public function update()
    {
        return true;
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @return mixed
     */
    public function delete()
    {
        return true;
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @return mixed
     */
    public function restore()
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @return mixed
     */
    public function forceDelete()
    {
        return false;
    }

    /**
     * Determine whether the user can attach labels or images to the task.
     *
     * @param User $user
     * @param Task $task
     * @return mixed
     */
    public function attach(User $user, Task $task)
    {
        return $user->id === $task->user_id
            ? Response::allow()
            : Response::deny('You do not own this task.');
    }

    /**
     * Determine whether the user can detach labels or images to the task.
     *
     * @param User $user
     * @param Task $task
     * @return mixed
     */
    public function detach(User $user, Task $task)
    {
        return $user->id === $task->user_id
            ? Response::allow()
            : Response::deny('You do not own this task.');
    }
}
