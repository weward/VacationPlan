<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayStoreRequest;
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

    public function store(HolidayStoreRequest $request)
    {
        $res = $this->service->store($request);

        if (!$res) {
            return response()->json(HolidayPlan::CREATE_FAILED, 500);
        }

        return new HolidayPlanResource($res);
    }

    public function show(Request $request, HolidayPlan $entity)
    {

    }

    public function update(Request $request, HolidayPlan $entity)
    {

    }

    public function destroy(HolidayPlan $entity)
    {
        
    }
}
