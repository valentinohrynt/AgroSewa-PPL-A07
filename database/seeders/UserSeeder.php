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
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        $users=[
            [
                'username'=>'superadmin@agrosewa',
                'password'=>'$2y$10$o3AB74vVXrqoM87bM6mYq.r5HflNhWkrGcfDXI3sbLfTYiJ3gr/eG',
                'email'=>'agrosewa.jember@gmail.com',
                'role_id'=>'1'
            ],
            [
                'username'=>'dinastphp@jember',
                'password'=>'$2y$10$gtMTVHaSCJu9VwSefCCHmuH./7IWyt7t4N2qT6oSDDzinLjZ6h7PK',
                'email'=>'jemberdiperta@yahoo.com',
                'role_id'=>'2'
            ],
            [
                'username'=>'sukamaju_poktan',
                'password'=>'$2y$10$kwQuCfykV8dgCg/rsdPmweEenJ9ObgNUbpbj8.hGNxUfcZz5YSh9m',
                'email'=>'sukamaju.jember@gmail.com',
                'role_id'=>'4'
            ],
            [
                'username'=>'mukti_poktan',
                'password'=>'$2y$10$/5B5t.BKzohyza2DjOmgWuefoLlT7nczPPcvRl0p50W66XAIo2rTa',
                'email'=>'mukti.jember@gmail.com',
                'role_id'=>'4'
            ]
        ];
        User::insert($users);
    }
}
