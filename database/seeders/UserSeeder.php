<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/jember-kt-user.csv"), "r");
      
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                User::create([
                    "id" => $data['0'],
                    "username" => $data['1'],
                    "password" => $data['2'],
                    "role_id" => $data['3']
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
        $users = [
            [
                'username' => 'superadmin@agrosewa',
                'password' => '$2y$10$o3AB74vVXrqoM87bM6mYq.r5HflNhWkrGcfDXI3sbLfTYiJ3gr/eG',
                'email' => 'agrosewa.jember@gmail.com',
                'role_id' => '1'
            ],
            [
                'username' => 'dinastphp@jember',
                'password' => '$2y$10$gtMTVHaSCJu9VwSefCCHmuH./7IWyt7t4N2qT6oSDDzinLjZ6h7PK',
                'email' => 'jemberdiperta@yahoo.com',
                'role_id' => '2'
            ]
        ];
        User::insert($users);
    }
}
