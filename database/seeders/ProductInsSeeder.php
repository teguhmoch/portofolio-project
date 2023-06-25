<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductIn;

class ProductInsSeeder extends Seeder
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
            ProductIn::updateOrCreate([
                'id' => 1,
                'product_id' => $product1->id,
                'qty' => 100,
                'added_by' => $user->id,
            ]);
            ProductIn::updateOrCreate([
                'id' => 2,
                'product_id' => $product2->id,
                'qty' => 200,
                'added_by' => $user->id,
            ]);
        }
    }
}
