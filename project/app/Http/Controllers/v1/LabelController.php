<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Label as LabelResource;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $labels = LabelResource::collection(Label::all());
        return response()->json(['result' => $labels]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LabelRequest $labelRequest
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(LabelRequest $labelRequest)
    {
        $this->authorize('create', Label::class);

        $label = Label::create([
            'label' => $labelRequest->label,
        ]);


        return response()->json(['result' => new LabelResource($label)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $this->authorize('view', $id);

        return response()->json(['result' => new LabelResource($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LabelRequest $labelRequest
     * @param Label $label
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(LabelRequest $labelRequest, Label $label)
    {
        $this->authorize('update', $label);
        $label->update([
            'label' => $labelRequest->label,
        ]);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Label $label)
    {
        $this->authorize('delete', $label);

        $label->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
