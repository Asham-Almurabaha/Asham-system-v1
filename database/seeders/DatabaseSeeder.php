<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Org\Database\Seeders\CitySeeder;
use Modules\Org\Database\Seeders\NationalitySeeder;
use Modules\Employees\Database\Seeders\EmployeeSeeder;
use Modules\Org\Database\Seeders\CompanySeeder;
use Modules\Org\Database\Seeders\BranchSeeder;
use Modules\Org\Database\Seeders\DepartmentSeeder;
use Modules\Org\Database\Seeders\JobSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            CitySeeder::class,
            PermissionsSeeder::class,
            NationalitySeeder::class,
            CompanySeeder::class,
            BranchSeeder::class,
            DepartmentSeeder::class,
            JobSeeder::class,
            // EmployeeSeeder::class,
        ]);
        
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
