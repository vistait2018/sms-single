<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeekAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['year_id','number','start_date','end_date'];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
