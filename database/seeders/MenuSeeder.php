<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        DB::table("menus")->insert([
            "kode_menu" => "mn001",
            "nama_menu" => "Dashboard",
            "url" => "dashboard",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 1,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn002",
            "nama_menu" => "User",
            "url" => "user",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 2,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn003",
            "nama_menu" => "Tiket",
            "url" => "tiket",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 3,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn004",
            "nama_menu" => "Printer",
            "url" => "",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 4,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn004-sm001",
            "nama_menu" => "All Printer",
            "url" => "printer",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn004",
            "aktif" => 1,
            "no_urut" => 5,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn004-sm002",
            "nama_menu" => "Relokasi Printer",
            "url" => "relokasi-printer",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn004",
            "aktif" => 1,
            "no_urut" => 7,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn004-sm003",
            "nama_menu" => "History Printer",
            "url" => "history-printer",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn004",
            "aktif" => 1,
            "no_urut" => 8,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn005",
            "nama_menu" => "Kanim",
            "url" => "kanim",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 9,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn006",
            "nama_menu" => "Konfigurasi",
            "url" => "",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 10,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn006-sm001",
            "nama_menu" => "Permission",
            "url" => "permission",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn006",
            "aktif" => 1,
            "no_urut" => 11,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn006-sm002",
            "nama_menu" => "Menu",
            "url" => "menu",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn006",
            "aktif" => 1,
            "no_urut" => 12,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
    }
}
