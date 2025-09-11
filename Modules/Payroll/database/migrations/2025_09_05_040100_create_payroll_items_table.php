<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('payroll_items')) {
            return;
        }

        $hasEmployees = Schema::hasTable('employees');
        $hasRuns = Schema::hasTable('payroll_runs');

        Schema::create('payroll_items', function (Blueprint $table) use ($hasEmployees, $hasRuns) {
            $table->id();
            if ($hasRuns) {
                $table->foreignId('payroll_run_id')->constrained('payroll_runs')->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('payroll_run_id');
            }
            if ($hasEmployees) {
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('employee_id');
            }
            $table->decimal('basic',12,2)->default(0);
            $table->json('allowances')->nullable();
            $table->json('deductions')->nullable();
            $table->decimal('overtime_amount',12,2)->default(0);
            $table->decimal('absence_amount',12,2)->default(0);
            $table->decimal('net',12,2)->default(0);
            $table->timestamps();
            $table->unique(['payroll_run_id','employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
    }
};
