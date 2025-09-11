<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'employees.view.any',
            'employees.view.branch',
            'employees.view.self',
            'employees.create',
            'employees.update',
            'employees.delete',
            'documents.manage',
            'leaves.request',
            'leaves.approve',
            'payroll.run',
            'payroll.post',
            'payroll.export_wps',
            'assets.assign',
            'assets.return',
            'expenses.approve',
            'fines.manage',
            'incidents.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $roles = [
            'HR Admin' => ['*'],
            'Payroll' => ['payroll.run','payroll.post','payroll.export_wps'],
            'Recruiter' => ['employees.view.any','employees.create','employees.update'],
            'Branch HR' => ['employees.view.branch'],
            'Manager' => ['employees.view.branch','leaves.approve'],
            'Safety Officer' => ['incidents.manage'],
            'Employee' => ['employees.view.self','leaves.request'],
        ];

        foreach ($roles as $name => $perms) {
            $role = Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
            if ($perms === ['*']) {
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions($perms);
            }
        }
    }
}
