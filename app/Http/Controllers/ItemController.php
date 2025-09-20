<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Equip;


class ItemController extends Controller
{
    //
    public function index(){
        
        $items = Item::with('equip')->latest()->get();
        $statuses = Item::STATUS_OPTIONS;
        $equips = Equip::withCount('items')->get();
        return view('admin.adminItem', ['items' => $items,'statuses'=>$statuses,'equips' => $equips]);
    }

    public function create(){
        $equips = Equip::orderBy('equip_name')->get();
        $statuses = Item::STATUS_OPTIONS;
        return view('admin.addItem',['equips'=>$equips,'statuses'=>$statuses]);
    }

    public function store(Request $request)
{
    $request->validate([
        'equip_id'     => 'required|exists:equips,id',
        'prefix'       => 'required|string|max:10',
        'start_number' => 'required|integer|min:1',
        'quantity'     => 'required|integer|min:1',
        'status'       => 'required|in:' . implode(',', array_keys(Item::STATUS_OPTIONS)),
    ]);

    $start = $request->start_number;
    $end = $start + $request->quantity;

    for ($i = $start; $i < $end; $i++) {
        // สร้างรหัสโดยเติม 0 ข้างหน้าให้ครบ 3 หลัก เช่น 001, 002, 010
        $number = str_pad($i, 3, '0', STR_PAD_LEFT);
        $assetCode = $request->prefix . '-' . $number;

        // ตรวจสอบก่อนว่ารหัสนี้มีคนใช้ไปแล้วหรือยัง
        if (Item::where('asset_code', $assetCode)->exists()) {
            // อาจจะ Redirect กลับไปพร้อม Error ว่ารหัสซ้ำ
            continue; // ข้ามรหัสนี้ไปก่อน (หรือจะให้ดีคือต้องแจ้ง Error)
        }

        Item::create([
            'equip_id'   => $request->equip_id,
            'asset_code' => $assetCode,
            'status'     => $request->status,
            'created_by' => Auth::id(),
        ]);
    }
    

    return redirect()->route('admin.item')->with('success', 'เพิ่มไอเทมเรียบร้อยแล้ว');
}

    public function edit(Item $item){
        $statuses = Item::STATUS_OPTIONS;
        return view('admin.editItem',['item'=>$item,'statuses'=>$statuses]);
    }

    public function update(Request $request,Item $item)
    {
        $request->validate([
            'status'=>'required|in:' .implode(',',array_keys(Item::STATUS_OPTIONS)),
        ]);

        $item->update([
        'status' => $request->status
    ]);
    // 6. Redirect กลับไปที่ Dashboard
    return redirect()->route('admin.item')
                     ->with('success', 'แก้ไขเรียบร้อยแล้ว!');
    }

    public function bulkUpdate(Request $request)
{
    $request->validate([
        // ตรวจสอบว่า item_ids ที่ส่งมาเป็น Array และมีค่าอย่างน้อย 1 ค่า
        'item_ids'   => 'required|array|min:1',
        // ตรวจสอบว่า ID ที่ส่งมาทั้งหมดมีอยู่จริงในตาราง items
        'item_ids.*' => 'exists:items,id',
        // ตรวจสอบว่า status ที่เลือกมาถูกต้อง
        'status'     => 'required|in:' . implode(',', array_keys(Item::STATUS_OPTIONS)),
    ]);

    $itemIds = $request->input('item_ids');
    $newStatus = $request->input('status');

    // อัปเดตข้อมูลทั้งหมดใน Query เดียว! (มีประสิทธิภาพสูงสุด)
    Item::whereIn('id', $itemIds)->update(['status' => $newStatus]);

    return redirect()->route('admin.item')->with('success', 'อัปเดตสถานะของไอเทม ' . count($itemIds) . ' ชิ้นเรียบร้อยแล้ว');
}

    public function destroy($id)
{
    $item = Item::findOrFail($id);
    $item->delete();


    return redirect()->route('admin.item')
                     ->with('success', 'ลบประกาศเรียบร้อยแล้ว');
}
}
