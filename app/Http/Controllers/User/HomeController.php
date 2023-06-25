<?php

namespace App\Http\Controllers\User;

use App\Models\TradingAccount;
use Illuminate\Http\Request;

class HomeController
{
    public function Index() {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('user.login');
        }


       
        return view('user.dashboard');
    }
}
