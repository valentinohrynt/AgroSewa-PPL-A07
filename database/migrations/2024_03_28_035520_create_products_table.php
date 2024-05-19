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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product_code')->unique();
            $table->enum('is_rented', ['yes', 'no'])->default('no');
            $table->text('product_description')->nullable();
            $table->integer('price');
            $table->string('product_img')->nullable();
            $table->float('utilization', 8, 5)->default(0.00);
            $table->unsignedBigInteger('lender_id');
            $table->foreign('lender_id')->references('id')->on('lenders');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
