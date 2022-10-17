<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            "role" => "administrator"
        ]);
        Role::create([
            "role" => "eos"
        ]);
        Role::create([
            "role" => "admin_kanim"
        ]);
    }
}
