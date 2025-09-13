<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('car_document_data_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_document_data_types');
    }
};
