<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentLevel extends Model
{
     protected $table = 'department_level';
    protected $fillable =[
        'department_id', 'level_id','year_id'
    ] ;
}
