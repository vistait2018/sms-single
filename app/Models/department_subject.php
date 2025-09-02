<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department_subject extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentSubjectFactory> */
    use HasFactory;

    protected $fillable = [ 'department_id', 'subject_id'];
}
