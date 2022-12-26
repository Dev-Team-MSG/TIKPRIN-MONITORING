<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $countTicket = $this->countTicket();
        $countUser = $this->countUser();
        $countPrinter = $this->countPrinter();
        $countCloseTicket = $this->countCloseTicket();
        $countTicketThisWeek = $this->countTicketThisWeek();
        $countTicketWeekAgo = $this->weekAgo();
        $countTicketToday = $this->countTicketToday();
        $countTicketThisMonth = $this->countTicketThisMonth();
        $countTicketThisYear = $this->countTicketThisYear();
        $getTicketThisWeek = $this->getTicketThisWeek();
        return view("index", compact(
            "countTicket",
            "countUser",
            'countPrinter',
            'countCloseTicket',
            'countTicketThisWeek',
            'countTicketWeekAgo',
            'countTicketToday',
            'countTicketThisMonth',
            'countTicketThisYear',
            'getTicketThisWeek'
        ));
    }

    static function countTicket()
    {
        $data = Ticket::all()->count();
        return $data;
    }

    static function countUser()
    {
        $data = User::all()->count();
        return $data;
    }

    static function countPrinter()
    {
        $data = Printer::all()->count();
        return $data;
    }

    static function countCloseTicket()
    {
        $data = Ticket::where("status", "=", "close")->count();
        return $data;
    }

    static function countTicketThisWeek()
    {
        $data = Ticket::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        return $data;
    }

    static function countTicketThisMonth()
    {
        $data = Ticket::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->count();
        return $data;
    }

    static function countTicketThisYear()
    {
        $data = Ticket::whereYear('created_at', date('Y'))->count();
        return $data;
    }

    static function weekAgo()
    {
        $todayMinusOneWeekAgo = \Carbon\Carbon::today()->subWeek();
        // dd(Ticket::where("created_at", $todayMinusOneWeekAgo)->count());
        $data = Ticket::where("created_at", $todayMinusOneWeekAgo)->count();
        return $data;
    }

    static function countTicketToday()
    {

        // dd(Ticket::whereDay('created_at', Carbon::now())->get());
        $data = Ticket::whereDay('created_at', Carbon::today())->count();
        return $data;
    }

    static function getTicketThisWeek()
    {
        $hari = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        $dataTicket = ["Sunday" => 0, "Monday" => 0, "Tuesday" => 0, "Wednesday" => 0, "Thursday" => 0, "Friday" => 0, "Saturday" => 0];
        // dd(Ticket::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::now()->endOfWeek()])->get());
        $data = Ticket::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('l');
            });
        // dd(count($data["Monday"]));
        foreach ($hari as $day) {
            # code...
            if (isset($data[$day])) {
                $dataTicket[$day] = count($data[$day]);
                // array_push($dataTicket[$day], count($data[$day]));
            }else {
                // array_push($dataTicket[$day], 0);
            }
        }

        // dd($dataTicket);
        return $dataTicket;
    }
}
