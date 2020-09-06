<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\LabelRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Jobs\UploadFileJob;
use App\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Task as TaskResource;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $tasks = TaskResource::collection(Task::paginate());
        return response()->json(['result' => $tasks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $taskStoreRequest
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(TaskStoreRequest $taskStoreRequest)
    {
        $this->authorize('create', Task::class);

        $task = Task::create([
            'title' => $taskStoreRequest->title,
            'board_id' => $taskStoreRequest->board_id,
            'status' => $taskStoreRequest->status
        ]);

        if(isset($taskStoreRequest->labels)){
            $task->labels()->attach($taskStoreRequest->labels);
        }

        return response()->json(['result' => new TaskResource($task)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $this->authorize('view', $id);

        return response()->json(['result' => new TaskResource($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->update([
            'title' => $request->title,
            'board_id' => $request->board_id,
            'status' => $request->status,
        ]);

        return response()->json([], Response::HTTP_NO_CONTENT);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);

    }

    /**
     * Attach label to the task.
     *
     * @param LabelRequest $labelRequest
     * @param Task $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function attachLabel(LabelRequest $labelRequest, Task $task)
    {
        $this->authorize('attach', $task);

        $task->labels()->attach($labelRequest->label);

        return response()->json([], Response::HTTP_NO_CONTENT);

    }

    /**
     * Delete label from the task.
     *
     * @param LabelRequest $labelRequest
     * @param Task $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function deleteLabel(LabelRequest $labelRequest, Task $task)
    {
        $this->authorize('detach', $task);

        $task->labels()->detach($labelRequest->label);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Attach image to the task.
     *
     * @param LabelRequest $labelRequest
     * @param Task $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function attachFile(FileRequest $fileRequest, Task $task)
    {
        $this->authorize('attach', $task);

        $originalImage= $fileRequest->file('filename');
        UploadFileJob::dispatch($task, $originalImage);

        return response()->json([], Response::HTTP_NO_CONTENT);

    }

}
