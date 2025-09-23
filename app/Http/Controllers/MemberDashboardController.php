<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipLoan;

class MemberDashboardController extends Controller
{
    //
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $equipLoans = $user->equipLoans()->with('item.equip')->get();
        $announcements = \App\Models\Announcement::latest()->get();
        return view('member',['equipLoans'=>$equipLoans,'announcements'=>$announcements]);
    }
}
