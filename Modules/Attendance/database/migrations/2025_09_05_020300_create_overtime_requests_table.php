<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('overtime_requests')) {
            return;
        }

        $hasEmployees = Schema::hasTable('employees');

        Schema::create('overtime_requests', function (Blueprint $table) use ($hasEmployees) {
            $table->id();
            if ($hasEmployees) {
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->foreignId('approver_id')->nullable()->references('id')->on('employees')->nullOnDelete();
            } else {
                $table->unsignedBigInteger('employee_id');
                $table->unsignedBigInteger('approver_id')->nullable();
            }
            $table->date('date');
            $table->unsignedInteger('minutes');
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtime_requests');
    }
};
