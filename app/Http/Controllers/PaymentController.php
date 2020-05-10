<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function payment(){

        $avaliblePlan = [
            'plan_HFWrZbpgc2NgjD'=> 'Energy Service 3',
            'plan_HFWsHuxs3AxfzU' => 'Energy Service 2',
            'plan_HFWtXARmedS2jk' => 'Energy Service 1'
        ];

        $data =[
            $user = Auth::user(),
            'intent' => $user->createSetupIntent(),
            'plans' => $avaliblePlan,
        ];
        return view('payment')->with($data);
    }

    public function subscribe(Request $request){

        $user = Auth::user();

        $paymentMethod = $request->payment_method;

        $planId=$request->plan;

         $suscribe = $user->newSubscription('main', $planId)->create($paymentMethod);
     return response([
         'data' => $suscribe,
        'message' => 'success',
        'status' => 200,
     ],200);
    }

    public function getCurrentPlan(){

        $subscribe = DB::table('subscriptions')->where('stripe_status','active')->get();
        return view('services.energy_service_1',compact('subscribe'));
    }
}
