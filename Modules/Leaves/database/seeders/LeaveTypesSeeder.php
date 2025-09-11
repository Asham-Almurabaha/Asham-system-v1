<?php

namespace Modules\Leaves\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Leaves\Models\LeaveType;

class LeaveTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['code' => 'ANNUAL', 'name' => 'Annual Leave', 'name_ar' => 'إجازة سنوية'],
            ['code' => 'SICK', 'name' => 'Sick Leave', 'name_ar' => 'إجازة مرضية'],
        ];

        foreach ($types as $type) {
            LeaveType::updateOrCreate(['code' => $type['code']], $type);
        }
    }
}
