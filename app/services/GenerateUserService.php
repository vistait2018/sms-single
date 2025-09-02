<?php
namespace App\Services;


use App\Models\User;
use App\Notifications\WelcomeUser;

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


   public static  function createUser($email, $school_id, $role): User{
     $data = [];
     $data['password']= self::generatePassword();
     $data['school_id']= $school_id;  
     $data['email']= $email;
    $user = User::create($data);
    $user->assignRole($role);
    $user->notify(new WelcomeUser($user));

    return $user;

   }
}