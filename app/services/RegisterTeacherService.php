<?php

namespace App\Services;

use App\Models\User;
use App\Models\Teacher;
use App\Notifications\WelcomeUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterTeacherService
{
    public function register(array $data): Teacher
    {
        return DB::transaction(function () use ($data) {
            // Create user
            $user = User::create([
                'name' => $data['first_name'].' '.$data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'] ?? 'password'),
                'school_id' => $data['school_id'],
            ]);

            $user->assignRole('teacher');
           

            // Create teacher
            $teacher = Teacher::create([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'address' => $data['address'] ?? null,
                'qualification' => $data['qualification'] ?? null,
                'date_of_employement' => $data['date_of_employement'] ?? null,
                'sex' => $data['sex'] ?? null,
                'dob' => $data['dob'] ?? null,
                'phone_no' => $data['phone_no'] ?? null,
                'religion' => $data['religion'] ?? null,
                'national' => $data['national'] ?? 'nigerian',
                'state_of_origin' => $data['state_of_origin'] ?? null,
                'previous_school_name' => $data['previous_school_name'] ?? null,
                'lga' => $data['lga'] ?? null,
                'level_id' => $data['level_id'] ?? null, // assign class-teacher
                'school_id' => $data['school_id'],
                'user_id' => $user->id,
            ]);
             $user->notify(new WelcomeUser($user));
            return $teacher->load('user'); 
        });
    }
}
