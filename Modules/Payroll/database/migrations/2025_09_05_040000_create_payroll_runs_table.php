<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('payroll_runs')) {
            return;
        }

        $hasCompanies = Schema::hasTable('companies');

        Schema::create('payroll_runs', function (Blueprint $table) use ($hasCompanies) {
            $table->id();
            if ($hasCompanies) {
                $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('company_id');
            }
            $table->string('month');
            $table->enum('status', ['draft','posted'])->default('draft');
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
            $table->unique(['company_id','month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_runs');
    }
};
