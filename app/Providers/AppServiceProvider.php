<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Ticket;
use Illuminate\Support\Facades\View;
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
        $count_open = Ticket::where("status", "open")->count();
        $count_progress = Ticket::where("status", "progress")->count();
        $count_close = Ticket::where("status", "close")->count();
        View::share('count_ticket', [$count_open, $count_progress, $count_close]);
    }
}
