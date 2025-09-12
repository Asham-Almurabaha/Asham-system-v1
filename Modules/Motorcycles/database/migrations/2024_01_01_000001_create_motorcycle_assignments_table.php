<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('motorcycle_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorcycle_id')->constrained('motorcycles')->cascadeOnDelete();
            $table->unsignedBigInteger('employee_id')->index();
            $table->dateTime('assigned_at');
            $table->dateTime('returned_at')->nullable();
            $table->string('condition_on_assign');
            $table->string('condition_on_return')->nullable();
            $table->string('handover_form_number',50)->nullable()->index();
            $table->unsignedBigInteger('assigned_by')->nullable()->index();
            $table->unsignedBigInteger('received_by')->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['motorcycle_id','returned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motorcycle_assignments');
    }
};
