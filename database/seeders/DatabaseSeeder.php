<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Cities\Database\Seeders\CitySeeder;
use Modules\Branches\Database\Seeders\BranchSeeder;
use Modules\Nationalities\Database\Seeders\NationalitySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            CitySeeder::class,
            BranchSeeder::class,
            PermissionsSeeder::class,
            NationalitySeeder::class,
            TitleSeeder::class,
        ]);
        
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
