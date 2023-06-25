<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProductCategory;

class ProductCategoriesSeeder extends Seeder
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
            ProductCategory::updateOrCreate([
                'id' => 1,
                'name' => 'Soft Drink',
                'description' => 'All About Softdrink',
                'added_by' => $user->id,
            ]);
            ProductCategory::updateOrCreate([
                'id' => 2,
                'name' => 'Instan Noddle',
                'description' => 'All About Instan Noodle',
                'added_by' => $user->id,
                'status' => 'inactive',
            ]);
        }
    }
}
