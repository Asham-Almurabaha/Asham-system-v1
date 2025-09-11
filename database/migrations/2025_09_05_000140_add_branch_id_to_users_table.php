<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'branch_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('id');
            });
        }

        if (Schema::hasTable('branches')) {
            $hasFk = Schema::getConnection()
                ->select("select constraint_name from information_schema.KEY_COLUMN_USAGE where table_schema = database() and table_name = 'users' and column_name = 'branch_id' and referenced_table_name is not null");
            if (empty($hasFk)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
                });
            }
        }
        // TODO: ensure branches table exists before adding FK in production
    }

    public function down(): void
    {
        $hasFk = Schema::getConnection()
            ->select("select constraint_name from information_schema.KEY_COLUMN_USAGE where table_schema = database() and table_name = 'users' and column_name = 'branch_id' and referenced_table_name is not null");
        if (! empty($hasFk)) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_branch_id_foreign');
            });
        }

        if (Schema::hasColumn('users', 'branch_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('branch_id');
            });
        }
    }
};

