<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Database\Seeders\SeveritySeeder;
use Database\Seeders\CategoryTicketSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Menu::create([
        //     "menu" => "printer",
        // ]);

        // Menu::create([
        //     "menu" => "tiket",
        // ]);

        // Role::create([
        //     "role" => "administrator"
        // ]);
        // Role::create([
        //     "role" => "eos"
        // ]);
        // Role::create([
        //     "role" => "admin_kanim"
        // ]);
        $this->call(CreateRoleSeeder::class);
        $this->call(CreateMenuSeeder::class);
        $this->call(CreateUserAccessSeeder::class);
        $this->call(CategoryTicketSeeder::class);
        $this->call(SeveritySeeder::class);
    }
}
