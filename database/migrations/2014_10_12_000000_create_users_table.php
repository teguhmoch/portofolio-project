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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullabled();
            $table->string('email')->nullabled()->unique();
            $table->bigInteger('nik')->nullabled();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullabled();
            $table->rememberToken()->nullabled();
            $table->string('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->char('status', 10)->default('inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
