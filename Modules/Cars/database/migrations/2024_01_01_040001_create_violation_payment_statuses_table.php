<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('violation_payment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->unique();
            $table->string('name_ar')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violation_payment_statuses');
    }
};
