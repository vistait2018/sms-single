<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelTeacher extends Model
{
    protected $table = 'level_teacher';
   protected $fillable =[
     'level_id','active','teacher_id','year_id'
   ];
}
