<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('name_en');
                $table->string('name_ar');
                $table->string('cr_number')->nullable();
                $table->string('vat_number')->nullable();
                $table->string('iban')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('companies', function (Blueprint $table) {
                if (!Schema::hasColumn('companies', 'name_en')) $table->string('name_en')->nullable();
                if (!Schema::hasColumn('companies', 'name_ar')) $table->string('name_ar')->nullable();
                if (!Schema::hasColumn('companies', 'cr_number')) $table->string('cr_number')->nullable();
                if (!Schema::hasColumn('companies', 'vat_number')) $table->string('vat_number')->nullable();
                if (!Schema::hasColumn('companies', 'iban')) $table->string('iban')->nullable();
                if (!Schema::hasColumn('companies', 'deleted_at')) $table->softDeletes();
            });
        }

        if (!Schema::hasTable('branches')) {
            Schema::create('branches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->nullable()->constrained('companies');
                $table->string('name_en');
                $table->string('name_ar');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('branches', function (Blueprint $table) {
                if (!Schema::hasColumn('branches', 'company_id')) {
                    $table->foreignId('company_id')->nullable()->constrained('companies');
                }
                if (!Schema::hasColumn('branches', 'name_en')) $table->string('name_en')->nullable();
                if (!Schema::hasColumn('branches', 'name_ar')) $table->string('name_ar')->nullable();
                if (!Schema::hasColumn('branches', 'is_active')) $table->boolean('is_active')->default(true);
                if (!Schema::hasColumn('branches', 'deleted_at')) $table->softDeletes();
            });
        }

        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->nullable()->constrained('companies');
                $table->foreignId('branch_id')->nullable()->constrained('branches');
                $table->string('name_en');
                $table->string('name_ar');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('departments', function (Blueprint $table) {
                if (!Schema::hasColumn('departments', 'company_id')) $table->foreignId('company_id')->nullable()->constrained('companies');
                if (!Schema::hasColumn('departments', 'branch_id')) $table->foreignId('branch_id')->nullable()->constrained('branches');
                if (!Schema::hasColumn('departments', 'name_en')) $table->string('name_en')->nullable();
                if (!Schema::hasColumn('departments', 'name_ar')) $table->string('name_ar')->nullable();
                if (!Schema::hasColumn('departments', 'is_active')) $table->boolean('is_active')->default(true);
                if (!Schema::hasColumn('departments', 'deleted_at')) $table->softDeletes();
            });
        }

        if (!Schema::hasTable('titles')) {
            Schema::create('titles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->nullable()->constrained('companies');
                $table->foreignId('branch_id')->nullable()->constrained('branches');
                $table->foreignId('department_id')->nullable()->constrained('departments');
                $table->string('name_en');
                $table->string('name_ar');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('titles', function (Blueprint $table) {
                if (!Schema::hasColumn('titles', 'company_id')) $table->foreignId('company_id')->nullable()->constrained('companies');
                if (!Schema::hasColumn('titles', 'branch_id')) $table->foreignId('branch_id')->nullable()->constrained('branches');
                if (!Schema::hasColumn('titles', 'department_id')) $table->foreignId('department_id')->nullable()->constrained('departments');
                if (!Schema::hasColumn('titles', 'name_en')) $table->string('name_en')->nullable();
                if (!Schema::hasColumn('titles', 'name_ar')) $table->string('name_ar')->nullable();
                if (!Schema::hasColumn('titles', 'is_active')) $table->boolean('is_active')->default(true);
                if (!Schema::hasColumn('titles', 'deleted_at')) $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        // Safe down: do nothing to preserve existing data
    }
};
