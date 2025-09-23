<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Equip;
use App\Models\User;
use App\Models\Item;
use App\Models\EquipLoan;

class EquipLoanController extends Controller
{
    //
    

    public function index(Request $request)
    {
        
        $activeLoans = EquipLoan::whereNull('returned_at')
                            ->with('user', 'item.equip')
                            ->latest()
                            ->get();
        return view('equipLoan',['equips'=>$activeLoans]);
    }

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

    public function returnItem(EquipLoan $equipLoan)
    {
        $eqipLoan->update(['returned_at'=>now()]);
        $equipLoan->update(['status'=>'Available']);
        return redirect()->route('admin.equipLoan.return')->with('success', 'รับคืน ' . $equipLoan->item->asset_code . ' เรียบร้อยแล้ว');
    }

    public function create()
    {
        $availableItems = Item::where('status','Available')->with('equip')->orderBy('asset_code')->get();
        $users = User::orderBy('name')->get();
        return view('equipLoan',['items'=>$availableItems,'users'=>$users]);
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

    public function pending()
{
    $pendingLoans = EquipLoan::whereNotNull('pending_return_at')
                             ->whereNull('returned_at')
                             ->with('user', 'item.equip')
                             ->get();

    return view('admin.pending', ['loans' => $pendingLoans]);
}

public function confirmReturn(EquipLoan $loan)
{
    // 1. อัปเดตรายการยืม: เติมวันที่คืนปัจจุบัน
    $loan->update(['returned_at' => now()]);

    // 2. อัปเดตสถานะไอเทม: เปลี่ยนจาก 'Pending Return' เป็น 'Available'
    $loan->item->update(['status' => 'Available']);

    return redirect()->route('admin.loans.pending')->with('success', 'ยืนยันการรับคืน ' . $loan->item->asset_code . ' เรียบร้อยแล้ว');
}

public function history()
{
    $allLoans = EquipLoan::with('user','item.equip')->latest()->paginate(20);// ใช้ paginate เพราะข้อมูลอาจจะเยอะมาก
    return view('admin.loanHistory',['loans'=>$allLoans]);
   // return view('admin.loanHistory',['loans'=>$allLoans]);
}
}
