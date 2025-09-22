<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    /** @use HasFactory<\Database\Factories\SalaryFactory> */
    use HasFactory;
    protected $table = 'salaries';

    protected $fillable =[
         'teacher_id',
            'amount',
           'year_id',
            'active',
    ];

     public function teacher(): BelongsTo
    {
        return $this->belongsTo(teacher::class);
    }
}
