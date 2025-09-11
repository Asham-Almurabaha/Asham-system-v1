<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('employees')) {
            return; // table already exists
        }

        $hasBranches = Schema::hasTable('branches');
        $hasDepartments = Schema::hasTable('departments');
        $hasTitles = Schema::hasTable('titles');
        $hasNationalities = Schema::hasTable('nationalities');

        Schema::create('employees', function (Blueprint $table) use ($hasBranches, $hasDepartments, $hasTitles, $hasNationalities) {
            $table->id();

            if ($hasBranches) {
                $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            } else {
                $table->unsignedBigInteger('branch_id')->nullable();
                // TODO: add foreign key to branches table when available
            }

            if ($hasDepartments) {
                $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            } else {
                $table->unsignedBigInteger('department_id')->nullable();
            }

            if ($hasTitles) {
                $table->foreignId('title_id')->nullable()->constrained()->nullOnDelete();
            } else {
                $table->unsignedBigInteger('title_id')->nullable();
            }

            if ($hasNationalities) {
                $table->foreignId('nationality_id')->nullable()->constrained()->nullOnDelete();
            } else {
                $table->unsignedBigInteger('nationality_id')->nullable();
            }

            $table->string('first_name', 100);
            $table->string('first_name_ar', 100);
            $table->string('last_name', 100);
            $table->string('last_name_ar', 100);
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->date('hire_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
