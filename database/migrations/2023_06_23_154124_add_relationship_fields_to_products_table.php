<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_category_id')->nullable()->after('id');
            $table->foreign('product_category_id', 'product_category_id_fk_8661480')->references('id')->on('product_categories');

            $table->unsignedBigInteger('supplier_id')->nullable()->after('product_category_id');
            $table->foreign('supplier_id', 'supplier_id_fk_8661599')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
