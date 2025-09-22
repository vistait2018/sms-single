<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceWeek extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceWeekFactory> */
    use HasFactory;
   protected $table = 'attendance_weeks';
    protected $fillable = ['year_id','term','active','school_id', 'number', 'start_date', 'end_date'];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
