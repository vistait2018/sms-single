<?php

namespace App\Services;


use App\Models\Student;




class RegisterStudentService
{
    public function register(array $data): Student
    {
       

            // Create student
            $student = Student::create([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'address' => $data['address'] ?? null,
                'sex' => $data['sex'] ?? null,
                'dob' => $data['dob'] ?? null,
                'phone_no' => $data['phone_no'] ?? null,
                'religion' => $data['religion'] ?? null,
                'national' => $data['national'] ?? 'nigerian',
                'state_of_origin' => $data['state_of_origin'] ?? null,
                'previous_school_name' => $data['previous_school_name'] ?? null,
                'lga' => $data['lga'] ?? null,

                'school_id' => $data['school_id'],

            ]);
           
            return $student;
      
    }
}
