<?php

use Illuminate\Database\Seeder;
Use App\Models\JobPosition;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $POSITIONS = [
            ['name' => 'Staff', 'pos_sequence' => 1],
            ['name' => 'Supervisor', 'pos_sequence' => 2],
            ['name' => 'Manager', 'pos_sequence' => 3],
            ['name' => 'General Manager', 'pos_sequence' => 4],
            ['name' => 'Director', 'pos_sequence' => 5],
            ['name' => 'President Director', 'pos_sequence' => 6],
            ['name' => 'Owner', 'pos_sequence' => 7],
        ];

        foreach($POSITIONS AS $key => $value) {
            JobPosition::create($value);
        }
    }
}
