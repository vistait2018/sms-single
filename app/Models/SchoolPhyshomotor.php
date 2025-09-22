<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolPhyshomotor extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolPhyshomotorFactory> */
    use HasFactory;
    protected $fillable = [
        'school_id',
        'name',
        'min_level',
        'max_level',
    ];

     public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
