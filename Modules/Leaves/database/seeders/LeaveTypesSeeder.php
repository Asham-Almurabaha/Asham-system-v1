<?php

namespace Modules\Leaves\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Leaves\Models\LeaveType;

class LeaveTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['code'=>'annual','name'=>'Annual'],
            ['code'=>'sick','name'=>'Sick'],
        ];
        foreach ($types as $t) {
            LeaveType::updateOrCreate(['code'=>$t['code']], $t);
        }
    }
}
