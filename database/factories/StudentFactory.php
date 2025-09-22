<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {




        $qualification = fake()->randomElement(['BSC','BED','OND','NCE']);
        $sex = fake()->randomElement(['male','female']);

        return [
              'first_name' => fake()->name(),
              'middle_name'=>fake()->name(),
               'last_name'=>fake()->name(),
               'address'=>fake()->address(),
                           'sex'=>$sex,
             'dob'=>fake()->dateTimeThisDecade(),
               'phone_no' => fake()->phoneNumber(),
            'religion' => fake()->randomElement(['christianity','islam','others']),
            'school_id' => 1,

        ];
    }
}
