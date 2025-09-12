<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_type_id')->constrained('car_types')->cascadeOnDelete();
            $table->foreignId('car_brand_id')->constrained('car_brands')->cascadeOnDelete();
            $table->string('name_en');
            $table->string('name_ar');
            $table->unique(['car_brand_id', 'name_en']);
            $table->unique(['car_brand_id', 'name_ar']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
