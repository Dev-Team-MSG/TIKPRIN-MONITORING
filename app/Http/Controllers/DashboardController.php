<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index() {
        $countTicket = $this->countTicket();
        $countUser = $this->countUser();
        $countPrinter = $this->countPrinter();
        $countCloseTicket = $this->countCloseTicket();
        return view("index", compact("countTicket", "countUser", 'countPrinter', 'countCloseTicket'));
    }

    static function countTicket() {
        $data = Ticket::all()->count();
        return $data;
    }

    static function countUser() {
        $data = User::all()->count();
        return $data;
    }

    static function countPrinter() {
        $data = Printer::all()->count();
        return $data;
    }

    static function countCloseTicket() {
        $data = Ticket::where("status", "=", "close")->count();
        return $data;
    }
}
