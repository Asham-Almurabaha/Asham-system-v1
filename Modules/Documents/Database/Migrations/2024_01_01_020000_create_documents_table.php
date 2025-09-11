<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('documents')) {
            Schema::create('documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees');
                $table->string('type');
                $table->string('number')->nullable();
                $table->string('issuer')->nullable();
                $table->date('issue_at')->nullable();
                $table->date('expire_at')->nullable()->index();
                $table->string('file_path')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('documents', function (Blueprint $table) {
                if (!Schema::hasColumn('documents','employee_id')) $table->foreignId('employee_id')->nullable()->constrained('employees');
                if (!Schema::hasColumn('documents','type')) $table->string('type');
                if (!Schema::hasColumn('documents','number')) $table->string('number')->nullable();
                if (!Schema::hasColumn('documents','issuer')) $table->string('issuer')->nullable();
                if (!Schema::hasColumn('documents','issue_at')) $table->date('issue_at')->nullable();
                if (!Schema::hasColumn('documents','expire_at')) { $table->date('expire_at')->nullable()->index(); }
                if (!Schema::hasColumn('documents','file_path')) $table->string('file_path')->nullable();
                if (!Schema::hasColumn('documents','notes')) $table->text('notes')->nullable();
                if (!Schema::hasColumn('documents','deleted_at')) $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        // no-op
    }
};
