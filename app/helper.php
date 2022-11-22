<?php

namespace App\Helpers;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function main_menu()
{
    $main_menu = DB::table("menus")
        ->leftjoin("accesses", "menus.kode_menu", "=", "accesses.kode_menu")
        ->select(["menus.*", "accesses.akses", "accesses.tambah", "accesses.edit", "accesses.hapus"])
        ->where("accesses.role_id", "=", Auth::user()->roles[0]->id)
        ->where("menus.aktif", "=", 1)
        ->where("menus.level", "=", "main_menu")
        ->orderBy("menus.no_urut", "ASC")
        ->get();
    return $main_menu;
}

function sub_menu()
{
    $sub_menu = DB::table("menus")
        ->leftjoin("accesses", "menus.kode_menu", "=", "accesses.kode_menu")
        ->select(["menus.*", "accesses.akses", "accesses.tambah", "accesses.edit", "accesses.hapus"])
        ->where("accesses.role_id", "=", Auth::user()->roles[0]->id)
        ->where("menus.aktif", "=", 1)
        ->where("menus.level", "=", "sub_menu")
        ->orderBy("menus.no_urut", "ASC")
        ->get();
    return $sub_menu;
}

function cek_akses_user()
{
    $path = request()->segments(2, 1);
    // $path = last(url()->current());
    // $path = end(explode("/", $path));

    $cek = DB::table("accesses")

        ->select("*")
        ->leftJoin("menus", "menus.kode_menu", "=", "accesses.kode_menu")
        ->where("accesses.role_id", "=", Auth::user()->roles[0]->id)
        ->where("menus.url", "LIKE" , $path[0] . "%")
        ->first();
        
    if (!$cek) {
        redirect(abort(403));
    } else {
        if ($cek->akses != 1) {
            redirect(abort(403));
        } else {
            return $cek;
        }
    }
}
