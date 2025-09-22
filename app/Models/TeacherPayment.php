<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherPayment extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherPaymentFactory> */
    use HasFactory;

    protected $table = 'teacher_payments';

    protected $fillable = [
    'teacher_id',
    'paid_by',
    'amount',
    'year_id',
    'month',
    'description',
    'status',
];


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(teacher::class);
    }
}
