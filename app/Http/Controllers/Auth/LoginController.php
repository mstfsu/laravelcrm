<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Company;
use Config;
use App\Models\Settings;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {Auth::guard('customers')->logout();
        $this->middleware('guest')->except('logout');
    }

    // Login
    public function showLoginForm(){
      $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
      ];

      return view('/auth/login2', [
          'pageConfigs' => $pageConfigs
      ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {   $user=$request->user();
        $user->status_id=2;
        $user->save();
        $this->guard()->logout();

        $request->session()->invalidate();


        return $this->loggedOut($request) ?: redirect('/login');
    }
    protected function authenticated(Request $request)
    {
        $user=$request->user();
        $user->status_id=1;
        $user->save();
        $tenant=$user->company_id;
        Config::set('app.timezone', Settings::get('time_zone'));
        // return redirect('/profile/'.auth()->user()->id);
    }
}
