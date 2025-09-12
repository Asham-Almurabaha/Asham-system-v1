<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique()->index();
            $table->string('vin')->unique()->nullable()->index();
            $table->foreignId('car_year_id')->nullable()->constrained('car_years')->cascadeOnDelete();
            $table->foreignId('car_type_id')->nullable()->constrained('car_types')->cascadeOnDelete();
            $table->foreignId('car_brand_id')->nullable()->constrained('car_brands')->cascadeOnDelete();
            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->cascadeOnDelete();
            $table->foreignId('car_color_id')->nullable()->constrained('car_colors')->cascadeOnDelete();
            $table->foreignId('car_status_id')->nullable()->constrained('car_statuses')->cascadeOnDelete();
            $table->date('purchase_date')->nullable();
            $table->decimal('cost',12,2)->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
