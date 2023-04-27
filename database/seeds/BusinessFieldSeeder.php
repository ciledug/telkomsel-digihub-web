<?php

use Illuminate\Database\Seeder;
use App\Models\BusinessField;

class BusinessFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $FIELDS = [
            ['name' => 'Communication'],
            ['name' => 'Mining'],
            ['name' => 'Finance'],
            ['name' => 'Hospitality'],
            ['name' => 'Tourism'],
            ['name' => 'Software Engineering'],
        ];

        foreach ($FIELDS AS $key => $value) {
            BusinessField::create($value);
        }
    }
}
