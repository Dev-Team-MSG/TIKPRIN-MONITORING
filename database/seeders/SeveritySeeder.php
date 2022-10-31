<?php

namespace Database\Seeders;

use App\Models\Severity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeveritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Severity::create([
            "severity"=> "Tinggi"
        ]);
        Severity::create([
            "severity"=> "Sedang"
        ]);
        Severity::create([
            "severity"=> "Rendah"
        ]);
    }
}
