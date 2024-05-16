<?php

namespace Database\Seeders;

use App\Models\Lender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Lender::truncate();
        Schema::enableForeignKeyConstraints();
        $csvFile = fopen(base_path("database/data/jember-kt.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Lender::create([
                    "name" => $data['0'],
                    "street" => $data['1'],
                    "village_id" => $data['2'],
                    "user_id" => $data['3']
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
