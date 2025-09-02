<?php

namespace Database\Seeders;

use App\enums\UserRole;
use App\Models\School;
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
     $schools = School::factory(100)->create();
     $roles = [];
       if (Role::count() === 0) {
            foreach (UserRole::cases() as $role) {
                $data = [
                    'name' => $role->value,
                    'guard_name' => 'web'
                ];

                 array_push($roles, Role::create($data));
            }
        }


        $super_admin = User::factory()->create([
            'name' => 'jide solanke',
            'email' => 'super@example.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),


        ]);
      $super_admin->assignRole('super-admin');


        $school_admin =  $super_admin = User::factory()->create([
            'name' => 'jide solanke',
            'email' => 'school-admin@example.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'school_id'=> $schools[0]->id,
        ]);




     $year = Year::create([
            'start_year' => '2024',
            'end_year' => '2025',
            'term' => 'first',
            'status' => 'active',
            'school_id'=>1
        ]);



      $school_admin->assignRole('school-admin');

      User::factory(100)->create()->each(function ($user) use ($schools, $roles) {
            if (!empty($roles)) {
                $randomRole = $roles[array_rand($roles)];
                // $randomRole is a Role model
               $user->assignRole($randomRole->id);
            }

            $user->school_id = $schools->random()->id;
            $user->save();
        });

         $this->call([
            PermissionSeeder::class,
        ]);

         $this->call([
            StatesAndLgaSeeder::class,
        ]);

    }
}
