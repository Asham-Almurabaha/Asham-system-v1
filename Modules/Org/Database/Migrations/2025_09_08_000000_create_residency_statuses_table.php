<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('residency_statuses')) {
            return; // TODO: merge with existing residency_statuses table
        }

        Schema::create('residency_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 100)->unique();
            $table->string('name_ar', 100)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residency_statuses');
    }
};

