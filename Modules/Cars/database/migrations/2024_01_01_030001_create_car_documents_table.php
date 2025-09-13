<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('car_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->foreignId('car_document_data_type_id')->constrained('car_document_data_types');
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('value')->nullable();
            $table->timestamps();
            $table->index(['car_id', 'name_en']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_documents');
    }
};
