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
        Schema::create('equipment_request_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_request_id');
            $table->foreign('equipment_request_id')->references('id')->on('equipment_requests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_request_logs');
    }
};
