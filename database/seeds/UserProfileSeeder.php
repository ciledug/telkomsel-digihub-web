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
        // UserProfile::create([
        //     'user_id' => 1,
        //     'client_id' => 'dalnet-test',
        //     'company' => 'PT Dalnet System',
        //     'join_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d'),
        //     'number_of_apis' => 0,
        //     'legal_entity' => 1,
        //     'business_field' => 1,
        //     'address' => 'Ruko Perkantoran Taman Kebon Jeruk',
        //     'company_site' => 'https://www.dalnetsystem.com',
        //     'contact_person' => 'Contact Person Name',
        //     'cp_position' => 1,
        //     'cp_email' => 'cp@dalnetsystem.com',
        //     'cp_phone' => '081234567890',
        //     'status' => 1,
        // ]);
    }
}
