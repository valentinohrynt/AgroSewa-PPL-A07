<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Village::truncate();
        Schema::enableForeignKeyConstraints();
        $csvFile = fopen(base_path("database/data/jember-villages.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Village::create([
                    "name" => $data['0'],
                    "district_id" => $data['1']
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
