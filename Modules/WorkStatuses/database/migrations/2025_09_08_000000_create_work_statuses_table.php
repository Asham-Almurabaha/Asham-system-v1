<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('work_statuses')) {
            Schema::create('work_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name_en');
                $table->string('name_ar');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('work_statuses', function (Blueprint $table) {
                if (!Schema::hasColumn('work_statuses', 'code')) {
                    $table->string('code')->unique();
                }
                if (!Schema::hasColumn('work_statuses', 'name_en')) {
                    $table->string('name_en');
                }
                if (!Schema::hasColumn('work_statuses', 'name_ar')) {
                    $table->string('name_ar');
                }
                if (!Schema::hasColumn('work_statuses', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('work_statuses');
    }
};

