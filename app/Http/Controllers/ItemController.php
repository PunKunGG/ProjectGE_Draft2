<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Equip;


class ItemController extends Controller
{
    //
    public function index(Request $request){
        
        $items = Item::with('equip')->latest()->get();
        $equips = Equip::withCount('items')->get();
        $statuses = Item::STATUS_OPTIONS;
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
        //'prefix'       => 'required|string|max:10',
        'quantity'     => 'required|integer|min:1',
        'status'       => 'required|in:' . implode(',', array_keys(Item::STATUS_OPTIONS)),
    ]);

    $equip = Equip::find($request->equip_id);
    $prefix = $equip->prefix;

    $last_item = Item::where('asset_code','LIKE',$prefix .'-%')
                    ->orderByRaw('CAST(SUBSTRING_INDEX(asset_code, "-", -1) AS UNSIGNED) DESC')
                    ->first();

    $start_number = 1;
    if($last_item){
        $last_number = (int) substr($last_item->asset_code,strrpos($last_item->asset_code, '-') + 1);
        $start_number = $last_number + 1;
    }
    $quantity = $request->quantity;
    $end_number = $start_number + $quantity;

    for ($i = $start_number; $i < $end_number; $i++) {
        // สร้างรหัสโดยเติม 0 ข้างหน้าให้ครบ 3 หลัก เช่น 001, 002, 010
        $number = str_pad($i, 3, '0', STR_PAD_LEFT);
        $assetCode = $prefix . '-' . $number;

        

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

    public function bulkEdit(){
        $items = Item::all();
        $statuses = Item::STATUS_OPTIONS;
        return view('admin.editBulkItem',compact('items','statuses'));
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

    $itemsToCheck = \App\Models\Item::whereIn('id', $itemIds)->get();

    // 3. วนลูปเช็คทีละตัวว่ามีสถานะเป็น 'Borrowed' หรือไม่
    foreach ($itemsToCheck as $item) {
        if ($item->status === 'Borrowed') {
            // 4. ถ้าเจอแม้แต่ชิ้นเดียว ให้หยุดทำงานและส่ง Error กลับไปทันที
            return redirect()->back()->with('error', 'ไม่สามารถแก้ไขสถานะของไอเทมที่ถูกยืมได้ (' . $item->asset_code . ')');
        }
    }
    // --- END: โค้ดป้องกัน ---


    // 5. ถ้าตรวจสอบผ่านทั้งหมด (ไม่มีชิ้นไหนถูกยืม) จึงทำการอัปเดต
    \App\Models\Item::whereIn('id', $itemIds)->update(['status' => $newStatus]);



    // อัปเดตข้อมูลทั้งหมดใน Query เดียว! (มีประสิทธิภาพสูงสุด)
    //Item::whereIn('id', $itemIds)->update(['status' => $newStatus]);

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
