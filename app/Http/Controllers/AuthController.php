<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;
use Hash;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.signin');
    }  
      

    public function createSignin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')
                        ->withSuccess('Logged-in');
        }
        return redirect("auth/login-v2")->withSuccess('Credentials are wrong.');
    }


    public function signup()
    {
        return view('auth-register-v2');
    }
      

    public function customSignup(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->createUser($data);
        return redirect("auth/login-v2")->withSuccess('Successfully logged-in!');
    }


    public function createUser(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    

    public function dashboardView()
    {
        if(Auth::check()){
            return view('dashboard-ecommerce');
        }
        return redirect("auth/login-v2")->withSuccess('Access is not permitted');
    }
    

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('auth/login-v2');
    }
}