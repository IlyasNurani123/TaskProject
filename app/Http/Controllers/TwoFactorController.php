<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    // show the two factor auth form
public function show2faForm()
{
    return view('two-fa');
}

// post token to the backend for check
public function verifyToken(Request $request)
{
    $rules = array(
        'token' => 'required'
    );
    $this->validate($request, $rules);

    $user = auth()->user();

    if ($request->token == $user->two_factor_token) {
        $user->two_factor_expiry = \Carbon\Carbon::now()->addWeeks(1);
        $user->save();
        return redirect()->intended('/dashboard');
    }

    return redirect('/two-fa')->with('message', 'Incorrect token.');
}
}
