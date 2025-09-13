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
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
            $table->index(['car_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_documents');
    }
};
