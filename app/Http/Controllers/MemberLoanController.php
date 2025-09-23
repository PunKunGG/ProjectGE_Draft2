<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Equip;
use App\Models\User;
use App\Models\Item;
use App\Models\EquipLoan;

class MemberLoanController extends Controller
{
    //
    public function indexForMember()
{
    // ดึง ID ของไอเทมทั้งหมดที่ผู้ใช้คนนี้ยืมและยังไม่คืน
    $myLoanItemIds = auth()->user()->equipLoans()
                            ->whereNull('returned_at')
                            ->pluck('item_id')
                            ->toArray();

    // ดึงไอเทมทั้งหมดที่ "พร้อมให้ยืม" หรือ "ถูกยืมโดยเรา"
    $items = Item::with('equip')
                 ->where('status', 'Available')
                 ->orWhereIn('id', $myLoanItemIds)
                 ->latest()
                 ->get();

    return view('equipLoan', [ // <-- ส่งไปที่ View ของ Member
        'items' => $items,
        'myLoanItemIds' => $myLoanItemIds,
    ]);
}

public function store(Request $request)
    {
        $request->validate([
            'item_id'=>'required|exists:items,id',
            'notes'=>'nullable|string',

        ]);

        $item = Item::find($request->item_id);
        if($item->status!=='Available'){
            return redirect()->back()->withErrors(['item_id'=>'อุปกรณ์ไม่พร้อมให้ยืม(สถานะปัจจุบัน: '. $item->status . ')']);
        }
        EquipLoan::create([
            'user_id'=>auth()->id(),
            'item_id'=>$request->item_id,
            'notes'=>$request->notes,
            'due_date'=>Carbon::today()->endOfDay(),
            'returned_at'=>null,
        ]);

        $item->update(['status'=>'Borrowed']);
        $item->save();
        
        return redirect()->back()->with('success','คุณได้ยืม'.$item->asset_code.' สำเร็จแล้ว');
    }
      public function requestReturn(Request $request, EquipLoan $loan)
    {
        // ป้องกันไม่ให้แจ้งคืนของของคนอื่น
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['return_photo' => 'required|image|max:2048']);
        
        $path = $request->file('return_photo')->store('return_photos', 'public');
        
        $loan->update([
            'pending_return_at' => now(),
            'return_photo_path' => $path,
        ]);
        
        $loan->item->update(['status' => 'Pending Return']);
        
        return redirect()->back()->with('success', 'แจ้งคืนอุปกรณ์เรียบร้อย รอกรรมการตรวจสอบ');
    }

    public function history()
{
    // ดึงประวัติการยืม "ทั้งหมด" (ทั้งที่คืนแล้วและยังไม่คืน) "เฉพาะของ user ที่ล็อกอินอยู่"
    $myHistory = auth()->user()->equipLoans()
                    ->with('item.equip')
                    ->latest()
                    ->paginate(15); // ใช้ paginate สำหรับแบ่งหน้า

    return view('myLoanHistory', ['loans' => $myHistory]);
}
}
