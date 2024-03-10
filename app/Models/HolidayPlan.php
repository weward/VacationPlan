<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPlan extends Model
{
    use HasFactory;

    protected $table = 'holiday_plans';

    const DEFAULT_PAGINATION_ROWS = 15;
    const CREATE_FAILED = 'Failed to save new holiday plan.';
    const UPDATE_FAILED = 'Failed to update holiday plan.';
    const DELETE_FAILED = 'Failed to delete holiday plan.';
    const DELETE_SUCCESS = 'Successfully deleted holiday plan.';

    protected $with = ['user'];

    protected $guarded = [];
    
    protected $casts = [
        'participants' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(fn(HolidayPlan $entity) => $entity->user_id = $entity->user_id ?? auth()->user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeOwn($query)
    {
        $query->where('user_id', auth()->user()->id);
    }

}
