<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayPlanStoreRequest;
use App\Http\Requests\HolidayPlanUpdateRequest;
use App\Http\Resources\HolidayPlanResource;
use App\Models\HolidayPlan;
use App\Services\HolidayPlanService;
use Illuminate\Http\Request;

class HolidayPlansController extends Controller
{
    public function __construct(private HolidayPlanService $service) {}

    public function index(Request $request)
    {
        $res = $this->service->filter($request);

        return HolidayPlanResource::collection($res);
    }

    public function store(HolidayPlanStoreRequest $request)
    {
        $res = $this->service->store($request);

        if (!$res) {
            return response()->json(HolidayPlan::CREATE_FAILED, 500);
        }

        return new HolidayPlanResource($res);
    }

    public function show(Request $request, HolidayPlan $entity)
    {
        $this->authorize('show', $entity);
        
        return new HolidayPlanResource($entity);
    }

    public function update(HolidayPlanUpdateRequest $request, HolidayPlan $entity)
    {
        $this->authorize('update', $entity);

        $res = $this->service->update($request, $entity);

        if (!$res) {
            return response()->json(HolidayPlan::UPDATE_FAILED, 500);
        }

        return new HolidayPlanResource($res);
    }

    public function destroy(HolidayPlan $entity)
    {
        $this->authorize('destroy', $entity);

        $res = $this->service->destroy($entity->id);

        if (!$res) {
            return response()->json(HolidayPlan::DELETE_FAILED, 500);
        }

        return response()->json(HolidayPlan::DELETE_SUCCESS, 204);
    }
}
