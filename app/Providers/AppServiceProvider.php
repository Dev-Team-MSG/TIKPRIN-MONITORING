<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Ticket;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        // dd(Auth::user());
        // if(Auth::user()->roles[0]->name == "engineer"){
        //     $count_open = Ticket::where("status", "open")->where("assign_id", null)->count();
        //     $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
        //     $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();

        // }else if(Auth::user()->roles[0]->name == "kanim"){
        //     $count_open = Ticket::where("status", "open")->where("assign_id", Auth::user()->id)->count();
        //     $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
        //     $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();


        // }else {
        //     $count_open = Ticket::where("status", "open")->count();
        //     $count_progress = Ticket::where("status", "progress")->count();
        //     $count_close = Ticket::where("status", "close")->count();
        // }
        
        // View::share('count_ticket', [$count_open, $count_progress, $count_close]);
    }
}
