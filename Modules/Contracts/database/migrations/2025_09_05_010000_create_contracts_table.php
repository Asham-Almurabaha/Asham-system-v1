<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('contracts')) {
            return;
        }

        $hasEmployees = Schema::hasTable('employees');

        Schema::create('contracts', function (Blueprint $table) use ($hasEmployees) {
            $table->id();
            if ($hasEmployees) {
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('employee_id');
            }
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->date('probation_end_at')->nullable();
            $table->string('type')->default('full_time');
            $table->decimal('housing_allowance',12,2)->default(0);
            $table->decimal('transport_allowance',12,2)->default(0);
            $table->json('other_allowances')->nullable();
            $table->string('status')->default('active');
            $table->string('attachment_path')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['employee_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
