<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\UserProfile;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserProfile::create([
            'user_id' => 1,
            'company' => 'PT Dalnet System',
            'join_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d'),
            'number_of_apis' => 12,
            'legal_entity' => 'PT (Perseroan Terbatas)',
            'business_field' => 'Communication',
            'address' => 'Ruko Perkantoran Taman Kebon Jeruk',
            'company_site' => 'https://www.dalnetsystem.com',
            'contact_person' => 'Contact Person',
            'cp_position' => 'Employee',
            'cp_email' => 'cp@dalnetsystem.com',
            'cp_phone' => '081234567890',
            'status' => 1,
        ]);
    }
}
