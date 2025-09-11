<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('wps_files')) {
            return;
        }

        $hasRuns = Schema::hasTable('payroll_runs');

        Schema::create('wps_files', function (Blueprint $table) use ($hasRuns) {
            $table->id();
            if ($hasRuns) {
                $table->foreignId('payroll_run_id')->constrained('payroll_runs')->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('payroll_run_id');
            }
            $table->string('file_path');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wps_files');
    }
};
