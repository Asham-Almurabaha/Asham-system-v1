<?php
namespace Database\Seeders;

use App\Models\User;
use Modules\Org\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web'; // عدّله لو عندك غارد مختلف

        if (!Schema::hasTable('roles') || !Schema::hasTable('permissions') || !Schema::hasTable('users')) {
            return;
        }

        // 1) أنشئ الصلاحيات (مثال – عدل القائمة حسب مشروعك)
        $permissions = [
            'users.view', 'users.create', 'users.update', 'users.delete',
        ];

        foreach ($permissions as $p) {
            Permission::findOrCreate($p, $guard);
        }

        $adminRole   = Role::findOrCreate('admin', $guard);
        $manager = Role::findOrCreate('manager', $guard);
        $entry   = Role::findOrCreate('data-entry', $guard);
        $viewer  = Role::findOrCreate('viewer', $guard);

        $adminRole->syncPermissions(Permission::all());

        $branchId = null;
        if (Schema::hasTable('branches') && Schema::hasColumn('users', 'branch_id')) {
            $adminBranch = Branch::firstOrCreate(
                ['name' => 'Administration'],
                [
                    'name_ar' => 'الإدارة',
                    'city_id' => Branch::query()->first()?->city_id ?? 1,
                    'is_active' => true,
                ]
            );
            $branchId = $adminBranch->id;
        }

        $adminuser = User::firstOrCreate(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ],
            [
                'password' => bcrypt('admin@123'),
                'branch_id' => $branchId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $testnuser = User::firstOrCreate(
            [
                'name' => 'Test',
                'email' => 'test@test.com',
            ],
            [
                'password' => bcrypt('test@123'),
                'branch_id' => $branchId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        if (!$adminuser->hasRole('admin')) {
            $adminuser->assignRole($adminRole);
        }
        
    }
}