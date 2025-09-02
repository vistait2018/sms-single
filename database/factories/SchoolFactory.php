<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\school>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $companyName = $this->faker->company;
        
         $type = fake()->randomElement(['primary', 'secondary']);
        return [
             'school_name'=>'st '.$companyName.' school '.$type,
             'address'=>fake()->address(),
             'phone_no'=>fake()->phoneNumber(),
              'phone_no2'=>fake()->phoneNumber(),
              'email'=>fake()->unique()->email(),
               'date_of_establishment'=>fake()
               ->date('Y-m-d','now'),
               'longitude'=>fake()->randomFloat(6, 4.272, 13.865),
               'latitude'=>fake()->randomFloat(6, 2.676, 14.678),
                'is_locked'=>fake()->randomElement([true,false]),
               'type'=>$type,

        ];
    }
}
