<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(3)->create();

        // insert real information
        DB::table('users')
            ->insert([
                "name" => "Super",
                "lastname" => "Administrador",
                "dni" => "admin",
                "password" => '$2y$10$v18L2DEt0jQnz8J4hWDDKOG0xJrHWGZSkbxWSHBIG8Nynhn/RuY4S',
                "email" => "admin",
                "role" => "Administrador",
                "description" => "I'm a maximus administrator",
                "facebook" => "https://www.facebook.com/ISTSucua"
            ]);
    }
}
