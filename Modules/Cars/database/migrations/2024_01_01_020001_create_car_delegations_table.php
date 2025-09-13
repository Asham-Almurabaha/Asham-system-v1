<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('car_delegations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->unsignedBigInteger('employee_id')->index();
            $table->foreignId('car_delegation_type_id')->constrained('car_delegation_types')->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->index(['car_id', 'employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_delegations');
    }
};
