<?php

namespace Modules\Attendance\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Attendance\Models\Shift;

class ShiftsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name'=>'standard_9_5','start_time'=>'09:00','end_time'=>'17:00','break_minutes'=>60],
            ['name'=>'night_8_4','start_time'=>'20:00','end_time'=>'04:00','break_minutes'=>45],
        ];
        foreach ($data as $d) {
            Shift::updateOrCreate(['name'=>$d['name']], $d);
        }
    }
}
