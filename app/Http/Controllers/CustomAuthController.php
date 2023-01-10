<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function custom_login(Request $request)
    {
        $request->validate([
            'email'     =>  'required',
            'password'  =>  'required'
        ]);

        $credential = $request->only('email', 'password');

        if(Auth::attempt($credential))
        {
            return redirect()->intended('dashboard')->withSuccess('Login');
        }

        return redirect('login')->with('error', 'Login Details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function custom_registration(Request $request)
    {
        $request->validate([
            'name'      =>  'required',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required|min:6'
        ]);

        $data = $request->all();

        User::create([
            'name'      =>  $data['name'],
            'email'     =>  $data['email'],
            'password'  =>  Hash::make($data['password']),
            'type'      =>  'Admin'
        ]);

        return redirect('registration')->with('success', 'Registration Complete');
    }

    public function dashboard()
    {
        if(Auth::check())
        {
            $today = Visitor::whereDate('created_at', '=', now()->today())->count();
            $yesterday = Visitor::whereDate('created_at', '>=', now()->subDays(1))->count();
            $week = Visitor::whereDate('created_at', '>=', now()->subWeek())->count();
            $month = Visitor::whereDate('created_at', '>=', now()->subMonth())->count();
            $year = Visitor::whereDate('created_at', '>=', now()->subYear())->count();
            // return $week;

            return view('dashboard-home', compact('today','yesterday','week','month','year'));
        }

        return redirect('login');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
