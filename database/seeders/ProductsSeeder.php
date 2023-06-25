<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('id',1)->first();
        $supplier = Supplier::where('id',1)->first();
        $category = ProductCategory::where('id',1)->first();
        if ($user && $supplier && $category) {
            Product::updateOrCreate([
                'id' => 1,
                'product_category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'name' => 'Coca Cola 250 ml',
                'description' => 'Coca cola isi 250 ml ',
                'price' => 4500,
                'added_by' => $user->id,
            ]);
            Product::updateOrCreate([
                'id' => 2,
                'product_category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'name' => 'Coca Cola Less Sugar',
                'description' => 'Coca cola less sugar rendah gula',
                'price' => 4500,
                'added_by' => $user->id,
            ]);
        }
    }
}
