<?php

namespace Database\Seeders;

use App\Models\CategoryTicket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CategoryTicket::create([
            "category" => "Maintenance H/W"
        ]);
        CategoryTicket::create([
            "category" => "Request ink/print-head"
        ]);
    }
}
