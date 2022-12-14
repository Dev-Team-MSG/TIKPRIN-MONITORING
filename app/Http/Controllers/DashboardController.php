<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index() {
        $countTicket = $this->countTicket();
        $countUser = $this->countUser();
        return view("index", compact("countTicket", "countUser"));
    }

    static function countTicket() {
        $data = Ticket::all()->count();
        return $data;
    }

    static function countUser() {
        $data = User::all()->count();
        return $data;
    }
}
