<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductOut;

class ProductOutsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('id',1)->first();
        $product1 = Product::where('id',1)->first();
        $product2 = Product::where('id',2)->first();
        if ($user && $product1 && $product2) {
            ProductOut::updateOrCreate([
                'id' => 1,
                'product_id' => $product1->id,
                'qty' => 20,
                'added_by' => $user->id,
            ]);
            ProductOut::updateOrCreate([
                'id' => 2,
                'product_id' => $product2->id,
                'qty' => 30,
                'added_by' => $user->id,
            ]);
        }
    }
}
