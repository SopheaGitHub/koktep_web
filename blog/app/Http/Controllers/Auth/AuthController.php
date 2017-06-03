<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/overview-account?login=success';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $request = \Request::all();
        $route_name = \Route::getCurrentRoute()->getPath();
        
        // log register
        if($route_name=='register') {
            if(\Request::isMethod('post')) {
                // add system log
                $this->systemLogs('submit_form', 'auth', $request);
                // End
            }else{
                // add system log
                $this->systemLogs('register', 'auth', $request);
                // End
            }
        }
        // End

        // log login
        if($route_name=='login') {
            if(\Request::isMethod('post')) {
                // add system log
                $this->systemLogs('submit_form', 'auth', $request);
                // End
            }else{
                // add system log
                $this->systemLogs('login', 'auth', $request);
                // End
            }
        }
        // End

        // log logout
        if($route_name=='logout') {
            // add system log
            $this->systemLogs('logout', 'auth', $request);
            // End
        }
        // End
        
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
