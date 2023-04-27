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
            ['name' => 'Staff'],
            ['name' => 'Manager'],
            ['name' => 'Supervisor'],
            ['name' => 'General Manager'],
        ];

        foreach($POSITIONS AS $key => $value) {
            JobPosition::create($value);
        }
    }
}
