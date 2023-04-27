<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\UserClientApi;

class UserClientApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        foreach ($products AS $key => $value) {
            UserClientApi::create([
                'user_id' => 1,
                'product_id' => $value->id,
            ]);
        }
    }
}
