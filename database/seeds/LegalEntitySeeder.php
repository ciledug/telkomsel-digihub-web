<?php

use Illuminate\Database\Seeder;
use App\Models\LegalEntity;

class LegalEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ENTITIES = [
            ['name' => 'Perseroan Terbatas (PT)'],
            ['name' => 'Perusahaan Daerah (PD)'],
            ['name' => 'CV'],
            ['name' => 'Firma (Fa)'],
        ];

        foreach ($ENTITIES AS $key => $value) {
            LegalEntity::create($value);
        }
    }
}
