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
        // Menu Dashboard
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
        // Menu User
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

        // Menu Tiket
        DB::table("menus")->insert([
            "kode_menu" => "mn003",
            "nama_menu" => "Tiket",
            "url" => "",
            "icon" => "fas fa-ticket",
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
            "kode_menu" => "mn003-sm001",
            "nama_menu" => "Open",
            "url" => "open-tiket",
            "icon" => "",
            "level" => "sub-menu",
            "main_menu" =>"mn003",
            "aktif" => 1,
            "no_urut" => 4,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn003-sm002",
            "nama_menu" => "Progress",
            "url" => "progress-tiket",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn003",
            "aktif" => 1,
            "no_urut" => 5,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn003-sm003",
            "nama_menu" => "Close",
            "url" => "close-tiket",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn003",
            "aktif" => 1,
            "no_urut" => 6,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn003-sm004",
            "nama_menu" => "Buat Tiket",
            "url" => "tiket/create",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn003",
            "aktif" => 1,
            "no_urut" => 7,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn003-sm005",
            "nama_menu" => "All Tiket",
            "url" => "tiket",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn003",
            "aktif" => 1,
            "no_urut" => 8,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
       
        // Menu Printer
        DB::table("menus")->insert([
            "kode_menu" => "mn004",
            "nama_menu" => "Printer",
            "url" => "",
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
            "kode_menu" => "mn004-sm001",
            "nama_menu" => "All Printer",
            "url" => "printer",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn004",
            "aktif" => 1,
            "no_urut" => 10,
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
            "no_urut" => 11,
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
            "no_urut" => 12,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);

        // Manu Kanim
        DB::table("menus")->insert([
            "kode_menu" => "mn005",
            "nama_menu" => "Kanim",
            "url" => "kanim",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 13,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);

        // Menu Konfigurasi
        DB::table("menus")->insert([
            "kode_menu" => "mn006",
            "nama_menu" => "Konfigurasi",
            "url" => "",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 14,
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
            "no_urut" => 15,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn006-sm002",
            "nama_menu" => "Menu",
            "url" => "menus",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn006",
            "aktif" => 1,
            "no_urut" => 16,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
        DB::table("menus")->insert([
            "kode_menu" => "mn006-sm003",
            "nama_menu" => "Role",
            "url" => "roles",
            "icon" => "",
            "level" => "sub_menu",
            "main_menu" =>"mn006",
            "aktif" => 1,
            "no_urut" => 17,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);

        // Menu Report
        DB::table("menus")->insert([
            "kode_menu" => "mn007",
            "nama_menu" => "Report",
            "url" => "reports",
            "icon" => "",
            "level" => "main_menu",
            "main_menu" =>"",
            "aktif" => 1,
            "no_urut" => 18,
            "created_by" => "admin",
            "updated_by" => "admin",
            "created_at" => date("Y:m:d H:i:s"),
            "updated_by"=> date("Y:m:d H:i:s"),
        ]);
    }
}
