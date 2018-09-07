<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loginCount = Activity::inLog('login')->causedBy(Auth::user())->count();
        // 最新登录信息
        $lastLogin = Activity::inLog('login')
            ->causedBy(Auth::user())
            ->latest()
            ->first();
        // 上次登陆信息
        $previousLogin = Activity::inLog('login')
            ->causedBy(Auth::user())
            ->where('id', '<', $lastLogin->id)
            ->orderBy('id', 'desc')
            ->first();
        return view('welcome', compact('loginCount', 'lastLogin', 'previousLogin'));
    }
}
