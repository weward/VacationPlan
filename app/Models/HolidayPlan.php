<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPlan extends Model
{
    use HasFactory;

    protected $table = 'holiday_plans';

    const DEFAULT_PAGINATION_ROWS = 15;

    protected $guarded = [];
    
    protected $casts = [
        'participants' => 'array',
    ];
    
    
    public function scopeOwn($query)
    {
        $query->where('user_id', auth()->user()->id);
    }

}
