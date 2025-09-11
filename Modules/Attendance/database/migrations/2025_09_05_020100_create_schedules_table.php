<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('schedules')) {
            return;
        }

        $hasEmployees = Schema::hasTable('employees');
        $hasShifts = Schema::hasTable('shifts');

        Schema::create('schedules', function (Blueprint $table) use ($hasEmployees, $hasShifts) {
            $table->id();
            if ($hasEmployees) {
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('employee_id');
            }
            $table->date('date');
            if ($hasShifts) {
                $table->foreignId('shift_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('shift_id');
            }
            $table->timestamps();
            $table->unique(['employee_id','date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
