<?php

namespace Database\Seeders;

use App\Models\Superadmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Superadmin::truncate();
        Schema::enableForeignKeyConstraints();
        $superadmin=[
            [
                'name'=>'Superadmin',
                'phone'=>'082143981626',
                'street'=>'Agrosewa',
                'village_id'=>'238',
                'user_id'=>'1'
            ]
        ];
        Superadmin::insert($superadmin);
    }
}
