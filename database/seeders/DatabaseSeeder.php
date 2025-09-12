<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Org\Database\Seeders\CitySeeder;
use Modules\Org\Database\Seeders\NationalitySeeder;
use Modules\Org\Database\Seeders\ResidencyStatusSeeder;
use Modules\Org\Database\Seeders\WorkStatusSeeder;
use Modules\Employees\Database\Seeders\EmployeeSeeder;
use Modules\Org\Database\Seeders\CompanySeeder;
use Modules\Org\Database\Seeders\BranchSeeder;
use Modules\Org\Database\Seeders\DepartmentSeeder;
use Modules\Org\Database\Seeders\JobSeeder;
use Modules\Cars\Database\Seeders\CarSeeder;
use Modules\Motorcycles\Database\Seeders\MotorcycleSeeder;
use Modules\Phones\Database\Seeders\PhoneSeeder;

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
            ResidencyStatusSeeder::class,
            WorkStatusSeeder::class,
            CompanySeeder::class,
            BranchSeeder::class,
            DepartmentSeeder::class,
            JobSeeder::class,
            CarSeeder::class,
            MotorcycleSeeder::class,
            PhoneSeeder::class,
            // EmployeeSeeder::class,
        ]);
        
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
