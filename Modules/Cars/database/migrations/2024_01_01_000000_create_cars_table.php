<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            // Allow up to three characters for license plate letters to
            // accommodate the seeded data which uses three Arabic letters.
            $table->string('plate_letters', 3);
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
