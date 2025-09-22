<?php
namespace App\Services;

use App\Models\Student;
use App\Models\User;
use App\Notifications\WelcomeUser;
use phpDocumentor\Reflection\Types\Boolean;

class GenerateUserService{

   

    public static function generatePassword(int $length = 12, bool $includeSymbols = true, bool $avoidAmbiguous = true): string
    {
        $upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower   = 'abcdefghijklmnopqrstuvwxyz';
        $digits  = '0123456789';
        $symbols = '!@#$%^&*()-_=+[]{};:,.<>?';

        $charset = $upper . $lower . $digits . ($includeSymbols ? $symbols : '');

        if ($avoidAmbiguous) {
            $charset = str_replace(['0', 'O', '1', 'l', 'I'], '', $charset);
        }

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $charset[random_int(0, strlen($charset) - 1)];
        }

        return $password;
    }


   public static  function createUser($name,$email, $school_id, $role): User{
     $data = [];
     $data['password']= self::generatePassword();
     $data['school_id']= $school_id;  
     $data['email']= $email;
     $data['name']= $name;
     $data['is_activated'] = true;
    $user = User::create($data);
    $user->assignRole($role);
    $user->notify(new WelcomeUser($user));

    return $user;

   }
  // remove: use phpDocumentor\Reflection\Types\Boolean;

public static function deActivateUser($student_id): bool
{
    $student = Student::findOrFail($student_id);
    $user  = User::findOrFail($student->user_id);

    return $user->update([
        'is_activated' => false,
    ]);
}




}