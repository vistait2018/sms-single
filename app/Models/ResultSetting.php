<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultSetting extends Model
{
     use HasFactory;

    protected $fillable = [
        'year_id', 'term_id', 'school_id', 'ca_total', 'exam_total'
    ];
}
