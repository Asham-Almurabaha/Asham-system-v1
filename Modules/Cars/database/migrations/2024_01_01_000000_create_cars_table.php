<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate_letters', 2);
            $table->string('plate_numbers', 4);
            $table->unique(['plate_letters', 'plate_numbers']);
            $table->string('sequence_number')->unique()->nullable()->index();
            $table->string('vin')->unique()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
