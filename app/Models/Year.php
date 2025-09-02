<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Year extends Model
{
    /** @use HasFactory<\Database\Factories\YearFactory> */
    use HasFactory;

    protected $fillable=[
         'start_year', 'end_year', 'term', 'status'
    ];

     public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
