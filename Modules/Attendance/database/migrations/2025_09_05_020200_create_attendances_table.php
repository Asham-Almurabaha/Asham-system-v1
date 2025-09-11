<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('attendances')) {
            return;
        }

        $hasEmployees = Schema::hasTable('employees');

        Schema::create('attendances', function (Blueprint $table) use ($hasEmployees) {
            $table->id();
            if ($hasEmployees) {
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('employee_id');
            }
            $table->timestamp('check_in_at')->nullable();
            $table->timestamp('check_out_at')->nullable();
            $table->enum('source', ['fingerprint','gps','manual'])->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->unsignedInteger('late_minutes')->default(0);
            $table->unsignedInteger('early_leave_minutes')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
