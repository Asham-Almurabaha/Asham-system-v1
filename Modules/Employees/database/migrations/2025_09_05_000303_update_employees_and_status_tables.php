<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('employment_statuses')) {
            Schema::create('employment_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name_en', 100)->unique();
                $table->string('name_ar', 100)->unique();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('work_statuses')) {
            Schema::create('work_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name_en', 100)->unique();
                $table->string('name_ar', 100)->unique();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('residency_statuses')) {
            Schema::create('residency_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name_en', 100)->unique();
                $table->string('name_ar', 100)->unique();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('sponsorship_statuses')) {
            Schema::create('sponsorship_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name_en', 100)->unique();
                $table->string('name_ar', 100)->unique();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (Schema::hasTable('employees')) {
            Schema::table('employees', function (Blueprint $table) {
                if (!Schema::hasColumn('employees', 'company_id')) {
                    $table->foreignId('company_id')->nullable()->constrained('companies');
                    $table->index(['company_id','branch_id']);
                }
                if (!Schema::hasColumn('employees', 'code')) $table->string('code')->nullable()->unique();
                if (!Schema::hasColumn('employees', 'manager_id')) $table->foreignId('manager_id')->nullable()->constrained('employees');
                if (!Schema::hasColumn('employees', 'national_id')) $table->string('national_id')->nullable();
                if (!Schema::hasColumn('employees', 'nationality')) $table->string('nationality')->nullable();
                if (!Schema::hasColumn('employees', 'dob')) $table->date('dob')->nullable();
                if (!Schema::hasColumn('employees', 'salary_basic')) $table->decimal('salary_basic',12,2)->default(0);
                if (!Schema::hasColumn('employees', 'currency')) $table->string('currency',3)->default('SAR');
                if (!Schema::hasColumn('employees', 'employment_status_id')) $table->foreignId('employment_status_id')->nullable()->constrained('employment_statuses');
                if (!Schema::hasColumn('employees', 'work_status_id')) $table->foreignId('work_status_id')->nullable()->constrained('work_statuses');
                if (!Schema::hasColumn('employees', 'sponsorship_status_id')) $table->foreignId('sponsorship_status_id')->nullable()->constrained('sponsorship_statuses');
                if (!Schema::hasColumn('employees', 'deleted_at')) $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('employees')) {
            Schema::table('employees', function (Blueprint $table) {
                if (Schema::hasColumn('employees', 'sponsorship_status_id')) {
                    $table->dropForeign(['sponsorship_status_id']);
                    $table->dropColumn('sponsorship_status_id');
                }
                if (Schema::hasColumn('employees', 'work_status_id')) {
                    $table->dropForeign(['work_status_id']);
                    $table->dropColumn('work_status_id');
                }
                if (Schema::hasColumn('employees', 'employment_status_id')) {
                    $table->dropForeign(['employment_status_id']);
                    $table->dropColumn('employment_status_id');
                }
                if (Schema::hasColumn('employees', 'currency')) {
                    $table->dropColumn('currency');
                }
                if (Schema::hasColumn('employees', 'salary_basic')) {
                    $table->dropColumn('salary_basic');
                }
                if (Schema::hasColumn('employees', 'dob')) {
                    $table->dropColumn('dob');
                }
                if (Schema::hasColumn('employees', 'nationality')) {
                    $table->dropColumn('nationality');
                }
                if (Schema::hasColumn('employees', 'national_id')) {
                    $table->dropColumn('national_id');
                }
                if (Schema::hasColumn('employees', 'manager_id')) {
                    $table->dropForeign(['manager_id']);
                    $table->dropColumn('manager_id');
                }
                if (Schema::hasColumn('employees', 'code')) {
                    $table->dropColumn('code');
                }
                if (Schema::hasColumn('employees', 'company_id')) {
                    $table->dropForeign(['company_id']);
                    $table->dropIndex(['company_id', 'branch_id']);
                    $table->dropColumn('company_id');
                }
                if (Schema::hasColumn('employees', 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }

        if (Schema::hasTable('sponsorship_statuses')) {
            Schema::drop('sponsorship_statuses');
        }
        if (Schema::hasTable('residency_statuses')) {
            Schema::drop('residency_statuses');
        }
        if (Schema::hasTable('work_statuses')) {
            Schema::drop('work_statuses');
        }
        if (Schema::hasTable('employment_statuses')) {
            Schema::drop('employment_statuses');
        }
    }
};
