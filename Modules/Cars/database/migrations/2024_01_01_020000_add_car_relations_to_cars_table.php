<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->foreignId('car_year_id')->nullable()->constrained('car_years')->cascadeOnDelete();
            $table->foreignId('car_type_id')->nullable()->constrained('car_types')->cascadeOnDelete();
            $table->foreignId('car_brand_id')->nullable()->constrained('car_brands')->cascadeOnDelete();
            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->cascadeOnDelete();
            $table->foreignId('car_color_id')->nullable()->constrained('car_colors')->cascadeOnDelete();
            $table->foreignId('car_status_id')->nullable()->constrained('car_statuses')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropConstrainedForeignId('car_year_id');
            $table->dropConstrainedForeignId('car_type_id');
            $table->dropConstrainedForeignId('car_brand_id');
            $table->dropConstrainedForeignId('car_model_id');
            $table->dropConstrainedForeignId('car_color_id');
            $table->dropConstrainedForeignId('car_status_id');
        });
    }
};
