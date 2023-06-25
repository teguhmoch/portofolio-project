<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function link($id) {
        $urlBroker = env('URL_BROKER', "https://www.exmarkets.digital");
        $urlRegister = url('/register/'.$id);
        $urlLogin = url('/login');
        
        return view('user.auth.link', compact('urlBroker', 'urlRegister', 'urlLogin'));
    }

    public function index(){
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email',$credentials['email'])->where('status','active')->first();
            $authUser = auth()->user();
            // $isPartner = $authUser->roles()->where('title', 'User')->first();
            if ($user) {
                $request->session()->put('user', $user);
                return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
            }           
        }
        session()->flash('error','Email or Password not valid');
  
        return redirect("login")->withSuccess('Login Successfully');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('user.login');
    }
}
