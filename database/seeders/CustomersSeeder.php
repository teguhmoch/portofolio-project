<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::updateOrCreate([
            'id' => 1,
            'name' => 'customer 1',
            'email' => 'customer@gmail.com',
            'address' => 'jljljljld',
        ]);
    }
}


