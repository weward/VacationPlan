<?php 

namespace App\Services;

use App\Interfaces\ApiCrudInterface;
use App\Models\HolidayPlan;
use Carbon\Carbon;

class HolidayPlanService implements ApiCrudInterface
{
    
    public function filter($request)
    {
        return HolidayPlan::with(['user'])->own()->paginate(HolidayPlan::DEFAULT_PAGINATION_ROWS);
    }

    public function store($request)
    {
        try {
            $entity = new HolidayPlan;
            $entity->title = $request->title;
            $entity->description = $request->description;
            $entity->date = Carbon::parse($request->date)->format('Y-m-d');
            $entity->location = $request->location;
            $entity->participants = $request->participants ?? [];
            $entity->save();
            
        } catch (\Throwable $th) {
            info($th->getMessage());
        }

        return $entity;
    }

    public function update($request, $entity)
    {
        try {
            $entity->title = $request->title ?? $entity->title;
            $entity->description = $request->description ?? $entity->description;
            $entity->date = Carbon::parse($request->date)->format('Y-m-d') ?? $entity->date;
            $entity->location = $request->location ?? $entity->location;
            $entity->participants = count($request->participants) ? $request->participants : [];

            $entity->save();
        } catch (\Throwable $th) {
            info($th->getMessage());
        }

        return $entity;
        
    }

    public function destroy($id)
    {
        try {
            $entity = HolidayPlan::find($id);

            $entity->delete();

        } catch (\Throwable $th) {
            info($th->getMessage());

            return false;
        }

        return true;
    }

}