<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ensure existing deployments upgrade the column length without
        // requiring the doctrine/dbal package.
        DB::statement('ALTER TABLE cars MODIFY plate_letters VARCHAR(3)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE cars MODIFY plate_letters VARCHAR(2)');
    }
};
