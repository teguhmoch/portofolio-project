<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('id',1)->first();
        if ($user) {
            Supplier::updateOrCreate([
                'id' => 1,
                'name' => 'PT. Coca Cola Company',
                'contact' => 2190938840,
                'address' => 'Jl. address no 11',
                'added_by' => $user->id,
                'status' => 'active',
            ]);
            Supplier::updateOrCreate([
                'id' => 2,
                'name' => 'PT. SSKI Cemerlang',
                'contact' => 2190938840,
                'address' => 'Jl. address no 12',   
                'added_by' => $user->id,
            ]);
        }
    }
}
