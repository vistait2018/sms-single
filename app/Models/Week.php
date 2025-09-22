<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    /** @use HasFactory<\Database\Factories\WeekFactory> */
    use HasFactory;

    protected $fillable = ['number', 'school_id', 'term', 'year_id'];
public function year()
{
    return $this->belongsTo(Year::class);
}

public function lessonNotes()
    {
        return $this->hasMany(LessonNote::class);
    }

}
