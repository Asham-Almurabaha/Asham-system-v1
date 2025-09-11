<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HrBaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        if (Schema::hasTable('employment_statuses')) {
            $employment = [
                ['code' => 'permanent', 'name_en' => 'Permanent', 'name_ar' => 'دائم', 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'contract', 'name_en' => 'Contract', 'name_ar' => 'عقد', 'created_at' => $now, 'updated_at' => $now],
            ];
            DB::table('employment_statuses')->upsert($employment, ['code'], ['name_en','name_ar','updated_at']);
        }

        if (Schema::hasTable('work_statuses')) {
            $work = [
                ['code' => 'on_duty', 'name_en' => 'On Duty', 'name_ar' => 'على رأس العمل', 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'terminated', 'name_en' => 'Terminated', 'name_ar' => 'مُنهي', 'created_at' => $now, 'updated_at' => $now],
            ];
            DB::table('work_statuses')->upsert($work, ['code'], ['name_en','name_ar','updated_at']);
        }

        if (Schema::hasTable('sponsorship_statuses')) {
            $sponsorship = [
                ['code' => 'company', 'name_en' => 'Company', 'name_ar' => 'على الشركة', 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'self', 'name_en' => 'Self', 'name_ar' => 'على الكفيل', 'created_at' => $now, 'updated_at' => $now],
            ];
            DB::table('sponsorship_statuses')->upsert($sponsorship, ['code'], ['name_en','name_ar','updated_at']);
        }
    }
}
