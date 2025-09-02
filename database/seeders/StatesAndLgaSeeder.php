<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\Lga;

class StatesAndLgaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/json/nigerian-states.json');

        $states = json_decode(file_get_contents($path), true);

        foreach ($states as $state => $lgas) {
            $newState = State::create(['name' => $state]);

            foreach ($lgas as $lga) {
                Lga::create([
                    'name'     => $lga,
                    'state_id' => $newState->id,
                ]);
            }
        }
    }
}
