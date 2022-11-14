<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Ticket;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\main_menu;
use function App\Helpers\sub_menu;

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
        // dd(Auth::guard("web")->check());

        View::composer("*", function ($view) {
            if (Auth::check()) {
                $main_menu = main_menu();
                $sub_menu = sub_menu();
                if (Auth::user()->roles[0]->name == "engineer") {
                    $count_open = Ticket::where("status", "open")->where("assign_id", null)->count();
                    $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
                    $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();
                } else if (Auth::user()->roles[0]->name == "kanim") {
                    $count_open = Ticket::where("status", "open")->where("assign_id", Auth::user()->id)->count();
                    $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
                    $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();
                } else {
                    $count_open = Ticket::where("status", "open")->count();
                    $count_progress = Ticket::where("status", "progress")->count();
                    $count_close = Ticket::where("status", "close")->count();
                }

                
                $view->with([
                    'main_menu' => $main_menu,
                    "sub_menu" => $sub_menu,
                    "count_open" => $count_open,
                    "count_close" => $count_close,
                    "count_progress" => $count_progress
                ]);
            }
        });
    }
}
