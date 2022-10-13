<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends Controller
{
    //tampilkan data
    public function index(){
        return view('crud');
    }

    //action untuk menampilkan form tambah data 
    public function tambah(){
        return view('crud-tambah-data');
    }
}
