<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('leaves')) {
            return;
        }

        $hasEmployees = Schema::hasTable('employees');
        $hasLeaveTypes = Schema::hasTable('leave_types');

        Schema::create('leaves', function (Blueprint $table) use ($hasEmployees, $hasLeaveTypes) {
            $table->id();
            if ($hasEmployees) {
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->foreignId('approver_id')->nullable()->references('id')->on('employees')->nullOnDelete();
            } else {
                $table->unsignedBigInteger('employee_id');
                $table->unsignedBigInteger('approver_id')->nullable();
            }
            if ($hasLeaveTypes) {
                $table->foreignId('leave_type_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('leave_type_id');
            }
            $table->date('start_at');
            $table->date('end_at');
            $table->decimal('days',8,2);
            $table->string('status')->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
