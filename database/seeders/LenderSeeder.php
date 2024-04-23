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
        $lenders=[
            [
                'name'=>'Sukamaju',
                'phone'=>'081246697653',
                'street'=>'DUSUN GUMUKBAGO',
                'village_id'=>'87',
                'user_id'=>'3'
            ],
            [
                'name'=>'Mukti',
                'phone'=>'082111196105',
                'street'=>'Jl. MT Haryono 148 Lingk Sumber Ketangi RT 001 RW 001 Kel Wirolegi',
                'village_id'=>'235',
                'user_id'=>'4'
            ]
        ];
        Lender::insert($lenders);
    }
}
