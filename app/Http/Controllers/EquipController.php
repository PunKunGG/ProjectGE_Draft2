<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equip;
use App\Models\Category;
use App\Models\Item;

class EquipController extends Controller
{
    //
    public function index(){
         $equips = Equip::with('items', 'category')->get();
        $all_statuses = Item::STATUS_OPTIONS;
        return view('admin.adminEquip', ['equips' => $equips,'all_statuses' => $all_statuses]);
    }
    public function create(){
        $categories = Category::orderBy('name')->get();
        return view('admin.addEquip',['categories'=>$categories]);
    }
    public function store(Request $request){
        $request->validate([
            'equip_name'=>'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);
        Equip::create([
            'equip_name'=>$request->equip_name,
            'category_id' => $request->category_id,
            'add_by'=>Auth::id(),
        ]);
        return redirect()->route('admin.equip')->with('success','เพิ่มอุปกรณ์เรียบร้อยแล้ว');
    }

    public function edit(Equip $equip)
    {
         $categories = Category::orderBy('name')->get();
        return view('admin.editEquip',['equip'=>$equip,'categories'=>$categories]);
    }

    public function update(Request $request,Equip $equip)
    {
        $request->validate([
            'equip_name'=>'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $data = $request->only('equip_name','category_id','quantity');

    
    // 5. อัปเดตข้อมูลในฐานข้อมูล
  $equip->update($data);

    // 6. Redirect กลับไปที่ Dashboard
    return redirect()->route('admin.equip')
                     ->with('success', 'แก้ไขเรียบร้อยแล้ว!');
    }

    public function destroy($id)
{
    $equip = Equip::findOrFail($id);
    $equip->delete();


    return redirect()->route('admin.equip')
                     ->with('success', 'ลบประกาศเรียบร้อยแล้ว');
}
}
