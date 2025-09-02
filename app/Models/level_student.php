<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class level_student extends Model
{
   protected $fillable = [
       'department_id', 'student_id', 'year_id', 'level_id', 'active', 'created_at', 'updated_at'
   ];
}
