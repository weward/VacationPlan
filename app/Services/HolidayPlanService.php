<?php 

namespace App\Services;

use App\Interfaces\ApiCrudInterface;
use App\Models\HolidayPlan;

class HolidayPlanService implements ApiCrudInterface
{
    
    public function filter($request)
    {
        return HolidayPlan::own()->paginate(HolidayPlan::DEFAULT_PAGINATION_ROWS);
    }

    public function store($request)
    {
        
    }

    public function fetch($id)
    {
    }

    public function update($request)
    {

    }

    public function destroy($id)
    {

    }

}