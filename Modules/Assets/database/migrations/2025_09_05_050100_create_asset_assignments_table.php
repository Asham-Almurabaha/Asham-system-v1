<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('asset_assignments')) {
            return;
        }

        $hasAssets = Schema::hasTable('assets');
        $hasEmployees = Schema::hasTable('employees');

        Schema::create('asset_assignments', function (Blueprint $table) use ($hasAssets, $hasEmployees) {
            $table->id();
            if ($hasAssets) {
                $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('asset_id');
            }
            if ($hasEmployees) {
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('employee_id');
            }
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->string('condition_out')->nullable();
            $table->string('condition_in')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['asset_id','returned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_assignments');
    }
};
