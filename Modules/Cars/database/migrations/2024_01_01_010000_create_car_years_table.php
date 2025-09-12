<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('car_years', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_years');
    }
};
