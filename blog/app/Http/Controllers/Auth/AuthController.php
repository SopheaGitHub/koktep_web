<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\ConfigController;

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
                $this->systemLogs('submit_form', 'auth', \Request::except('password', 'password_confirmation'));
                // End
            }else{
                // add system log
                $this->systemLogs('register', 'auth', \Request::except('password', 'password_confirmation'));
                // End
            }
        }
        // End

        // log login
        if($route_name=='login') {
            if(\Request::isMethod('post')) {
                // add system log
                $this->systemLogs('submit_form', 'auth', \Request::except('password'));
                // End
            }else{
                // add system log
                $this->systemLogs('login', 'auth', \Request::except('password'));
                // End
            }
        }
        // End

        // log logout
        if($route_name=='logout') {
            // add system log
            $this->systemLogs('logout', 'auth', \Request::except('password'));
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
        $rules = [];
        $messages = [];

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $messages = [
            'name.required' => trans('auth.name_required'),
            'name.max' => trans('auth.name_max_255'),
            'email.required' => trans('auth.email_required'),
            'email.email' => trans('auth.email_email'),
            'email.max' => trans('auth.email_max_255'),
            'email.unique' => trans('auth.email_unique'),
            'password.required' => trans('auth.password_required'),
            'password.min' => trans('auth.password_min_6'),
            'password.confirmed' => trans('auth.password_in_confirmed')
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $config = new ConfigController();
        return User::create([
            'name' => $config->escape($data['name']),
            'email' => $config->escape($data['email']),
            'password' => bcrypt($data['password']),
            'status' => '1'
        ]);
    }
}
