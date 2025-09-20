<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipLoan;

class DashboardController extends Controller
{
    //
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
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function dashboard()
    {
        return view('member');
    }
    public function adminDashboard()
    {
        return view('admin.adminDashboard');
    }

    public function index()
    {
        $user = Auth::user();
        $loans = $user->loans()->with('equip')->get();
        $announcements = \App\Models\Announcement::latest()->get();
        return view('admin.adminDashboard',['loans'=>$loans,'announcements'=>$announcements]);
    }
    
    public function addAnnounce()
    {
        return view('admin.addAnnounce');
    }

}
