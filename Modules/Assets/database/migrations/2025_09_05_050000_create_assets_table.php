<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('assets')) {
            return;
        }

        $hasBranches = Schema::hasTable('branches');

        Schema::create('assets', function (Blueprint $table) use ($hasBranches) {
            $table->id();
            if ($hasBranches) {
                $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            } else {
                $table->unsignedBigInteger('branch_id')->nullable();
            }
            $table->string('type');
            $table->string('serial')->unique();
            $table->string('description')->nullable();
            $table->decimal('cost',12,2)->default(0);
            $table->enum('status',['available','assigned','maintenance','lost'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
