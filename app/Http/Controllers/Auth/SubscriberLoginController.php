<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use App\Http\Controllers\Auth\LoginController as DefaultLoginController;
class SubscriberLoginController  extends DefaultLoginController
{protected $redirectTo = '/Customer/index';
    public function __construct()
    {
        $this->middleware('guest:customers')->except('logout','customerlogout');;
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function username()
    {
        return 'username';
    }
    public function password()
    {
        return 'password';
    }
    protected function guard()
    {
        return Auth::guard('customers');
    }
    public function login(Request $request)
    {


        $this->validateLogin($request);

        if(Auth::guard('customers')->attempt(['username'=>$request->username,'password'=>$request->password],false))
        {
            Auth::guard('web')->logout();
            return redirect()->intended(route('customers-dashboard'));
        }
        else{
            
            return redirect()->back()->withInput($request->only('username', 'remember'));
        }

    }
    public function customerlogout(Request $request)
    {
        Auth::guard('customers')->logout();

        $request->session()->invalidate();


        return $this->loggedOut($request) ?: redirect('/Customer/login');
    }
    protected function validateLogin(Request $request)
    {
        log::info( $this->username());
        $res=$request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
        log::info($res);
    }
    


}
