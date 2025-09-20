<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equip;
use App\Models\User;

class EquipLoanController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Equip::query();
        if($request->has('search')){
            $query->where('equip_name','like','%'.$request->search . '%');
        }
        $equips = $query->latest()->with('category')->get();
        return view('equipLoan',['equips'=>$equips]);
    }
}
