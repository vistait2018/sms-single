<?php

namespace Database\Seeders;

use App\enums\UserRole;
use App\Models\LevelStudent;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Year;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
    //  $schools = School::factory(100)->create();
    //  $roles = [];
    //    if (Role::count() === 0) {
    //         foreach (UserRole::cases() as $role) {
    //             $data = [
    //                 'name' => $role->value,
    //                 'guard_name' => 'web'
    //             ];

    //              array_push($roles, Role::create($data));
    //         }
    //     }


    //     $super_admin = User::factory()->create([
    //         'name' => 'jide solanke',
    //         'email' => 'super@example.com',
    //         'email_verified_at' => now(),
    //         'remember_token' => Str::random(10),


    //     ]);
    //   $super_admin->assignRole('super-admin');


    //     $school_admin =  $super_admin = User::factory()->create([
    //         'name' => 'jide solanke',
    //         'email' => 'school-admin@example.com',
    //         'email_verified_at' => now(),
    //         'remember_token' => Str::random(10),
    //         'school_id'=> $schools[0]->id,
    //     ]);




    //  $year = Year::create([
    //         'start_year' => '2024',
    //         'end_year' => '2025',
    //         'term' => 'first',
    //         'status' => 'active',
    //         'school_id'=>1
    //     ]);



    //   $school_admin->assignRole('school-admin');

    //   User::factory(100)->create()->each(function ($user) use ($schools, $roles) {
    //         if (!empty($roles)) {
    //             $randomRole = $roles[array_rand($roles)];
    //             // $randomRole is a Role model
    //            $user->assignRole($randomRole->id);
    //         }

    //         $user->school_id = $schools->random()->id;
    //         $user->save();
    //     });

    //      $this->call([
    //         PermissionSeeder::class,
    //     ]);

    //      $this->call([
    //         StatesAndLgaSeeder::class,
    //     ]);


//Teacher::factory()->count(50)->create();

  // Student::factory()->count(500)->create();

 // $students = Student::all();

// Get active year for school 1
// $activeYear = Year::where('school_id', 1)
//     ->where('status', 'active')
//     ->first();

// if (!$activeYear) {
//     throw new \Exception('No active year found for this school.');
// }

// $year_id = $activeYear->id;
// $levelStudentData = [];
// $count = 0;

// foreach ($students as $student) {
//     $count++;

//     // Default values
//     $department_id = 1;
//     $level_id = 1;

//     // Set based on the record number
//     if ($count >= 20 && $count < 50) {
//         $department_id = 2;
//         $level_id = 2;
//     } elseif ($count >= 50 && $count < 90) {
//         $department_id = 3;
//         $level_id = 3;
//     } elseif ($count >= 90 && $count < 110) {
//         $department_id = 4;
//         $level_id = 4;
//     } elseif ($count >= 110 && $count < 170) {
//         $department_id = 5;
//         $level_id = 5;
//     } elseif ($count >= 170 && $count < 250) {
//         $department_id = 6;
//         $level_id = rand(6, 8);
//     } elseif ($count >= 250) {
//         $department_id = 7;
//         $level_id = rand(9, 10);
//     }

//     $levelStudentData[] = [
//         'department_id' => $department_id,
//         'student_id'    => $student->id,
//         'year_id'       => $year_id,
//         'level_id'      => $level_id,
//         'active'        => true,
//         'created_at'    => now(),
//         'updated_at'    => now(),
//     ];
// }

// Bulk insert
//LevelStudent::insert($levelStudentData);

$this->call(CommentsSeeder::class);


    }
}
