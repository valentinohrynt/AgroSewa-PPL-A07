<?php

namespace Database\Seeders;

use App\Models\Government;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GovernmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Government::truncate();
        Schema::enableForeignKeyConstraints();
        $government=[
            [
                'name'=>'Dinas TPHP Jember',
                'phone'=>'0331482787',
                'street'=>'Jl. Brawijaya No.71',
                'village_id'=>'227',
                'user_id'=>'1550'
            ]
        ];
        Government::insert($government);
    }
}