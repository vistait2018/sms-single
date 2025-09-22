<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonNote extends Model
{
    /** @use HasFactory<\Database\Factories\LessonNoteFactory> */
    use HasFactory;

    protected $fillable = [
        'written_by_id',
        'level_id',
        'school_id',
        'note_url',
        'week',
        'term',
        'year_id'

    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'written_by_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }
}
