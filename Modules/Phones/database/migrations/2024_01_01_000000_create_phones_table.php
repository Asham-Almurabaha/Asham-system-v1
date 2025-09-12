<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->string('imei')->unique()->index();
            $table->string('serial_number')->unique()->nullable()->index();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->string('line_number')->nullable()->index();
            $table->string('status')->default('available');
            $table->date('purchase_date')->nullable();
            $table->decimal('cost',12,2)->nullable();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
