<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Employees\Models\Employee;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->unsignedBigInteger('employee_id')->index();
            $table->foreignId('violation_type_id')->constrained('violation_types')->cascadeOnDelete();
            $table->foreignId('violation_payment_status_id')->constrained('violation_payment_statuses')->cascadeOnDelete();
            $table->string('violation_number')->unique();
            $table->date('violation_date')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
