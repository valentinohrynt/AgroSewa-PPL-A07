<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DistrictSeeder::class,
            VillageSeeder::class,
            UserSeeder::class,
            SuperadminSeeder::class,
            GovernmentSeeder::class,
            LenderSeeder::class,
            ProductCategorySeeder::class
        ]);
    }
}
