<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $status = $request->filter_status;

        $events = Event::when($status, function ($query, $status) {
            if ($status == "1") {
                // Upcoming events
                $query->whereDate('start_date', '>=', date('Y-m-d'));
            } else if ($status == "2") {
                // Finished events
                $query->whereDate('end_date', '<=', date('Y-m-d'));
            } else if ($status == "3") {
                // Upcoming events within 7 days
                $from = date("Y-m-d");
                $to = date("Y-m-d", strtotime("$from +7 day"));
                $query->whereBetween('start_date', [$from, $to]);
            } else {
                // Finished events of the last 7 days
                $yesterday = date("Y-m-d");
                $to = date("Y-m-d", strtotime("$yesterday -1 day"));
                $from = date("Y-m-d", strtotime("$to -7 day"));

                $query->whereBetween('end_date', [$from, $to]);
            }
        })->orderBy('start_date', 'ASC')->paginate(5);

        return view('home', compact('events', 'status'));
    }
}
