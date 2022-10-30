<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
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
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        $kanim = User::create(array_merge([
            "email" => "kanim@gmail.com",
            "name" => "kanim"
        ], $default_user_value));
        $admin = User::create(array_merge([
            "email" => "admin@gmail.com",
            "name" => "admin"
        ], $default_user_value));
        $engineer = User::create(array_merge([
            "email" => "engineer@gmail.com",
            "name" => "engineer"
        ], $default_user_value));
        $role_kanim = 11;
        $role_engineer = 10;
        $role_admin = 12;

        $kanim->syncRoles($role_kanim);
        $admin->syncRoles($role_admin);
        $engineer->syncRoles($role_engineer);
    }
}
