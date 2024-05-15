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
        Schema::create('equipment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pdf_file_name')->nullable();
            $table->string('equipment_request_number')->unique();
            $table->unsignedBigInteger('lender_id');
            $table->foreign('lender_id')->references('id')->on('lenders');
            $table->enum('is_approved', ['process', 'accepted', 'rejected'])->default('process');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_requests');
    }
};
