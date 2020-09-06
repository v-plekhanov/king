<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardStoreRequest;
use App\Models\Board;
use App\Http\Resources\Board as BoardResource;
use App\Http\Resources\BoardShow as BoardShowResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class BoardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $boards = BoardResource::collection(Board::paginate());
        return response()->json(['result' => $boards]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BoardStoreRequest $boardStoreRequest
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(BoardStoreRequest $boardStoreRequest)
    {
        $this->authorize('create', Board::class);

        $task = Board::create([
            'name' => $boardStoreRequest->name,
        ]);

        return response()->json(['result' => new BoardResource($task)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(new BoardShowResource($id));
    }


}
