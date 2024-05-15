<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProductCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Traktor Roda 2', 'Traktor Roda 4', 'Pompa Air', 'Hand Sprayer', 'Excavator', 'Lainnya'
        ];
        foreach ($data as $value) {
            ProductCategory::insert([
                'name' => $value
            ]);
        }
    }
}
