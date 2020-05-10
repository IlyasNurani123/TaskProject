<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $subscribe = DB::table('subscriptions')->where('stripe_status','active')->get();
        return view('dashboard',compact('subscribe'));
    }

    public function energy_service_1()
    {
        $subscribe = DB::table('subscriptions')->where('stripe_status','active')->get();
            return view('services.energy_service_1',compact('subscribe'));
    }
    public function energy_service_2()
    {
        $subscribe = DB::table('subscriptions')->where('stripe_status','active')->get();
        return view('services.energy_service_2',compact('subscribe'));
    }
    public function energy_service_3()
    {
        $subscribe = DB::table('subscriptions')->where('stripe_status','active')->get();
        return view('services.energy_service_3',compact('subscribe'));
    }

}
