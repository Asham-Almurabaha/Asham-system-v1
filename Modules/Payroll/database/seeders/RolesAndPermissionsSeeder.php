<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(\Spatie\Permission\Models\Role::class)) {
            Log::info('TODO: install spatie/permission for payroll roles');
            return;
        }
        $perm = \Spatie\Permission\Models\Permission::firstOrCreate(['name'=>'payroll.manage']);
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'Payroll']);
        $role->givePermissionTo($perm);
    }
}
