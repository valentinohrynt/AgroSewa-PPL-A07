<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        District::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'KENCONG', 'GUMUKMAS', 'PUGER', 'WULUHAN','AMBULU','TEMPUREJO','SILO','MAYANG','MUMBULSARI','JENGGAWAH','AJUNG', 'RAMBIPUJI','BALUNG','UMBULSARI','SEMBORO','JOMBANG','SUMBERBARU','TANGGUL','BANGSALSARI','PANTI','SUKORAMBI','ARJASA','PAKUSARI','KALISAT','LEDOKOMBO','SUMBERJAMBE','SUKOWONO','JELBUK','KALIWATES','SUMBERSARI','PATRANG'
        ];
        foreach ($data as $value) {
            District::insert([
                'name'=> $value
            ]);
        }
    }
}
