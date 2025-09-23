<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnounceController extends Controller
{
    //
    public function create()
    {
        return view('admin.addAnnounce');
    }

    public function store(Request $request)
    {
        //ตรวจสอบข้อมูลที่ส่งมา
        $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;

        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('announcements','public');
        }

        Announcement::create([
            'message' => $request->message,
            'img_path' => $imagePath,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('admin.dashboard')->with('success','สร้างประกาศเรียบร้อยแล้ว');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.editAnnouce',['announcement'=>$announcement]);
    }

    public function update(Request $request,Announcement $announcement)
    {
     // 1. ตรวจสอบข้อมูล
    $request->validate([
        'message' => 'required|string',
        'image' => 'nullable|image|max:2048'
    ]);

    $data = $request->only('message');

    // 2. ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่หรือไม่
    if ($request->hasFile('image')) {
        // 3. ลบรูปภาพเก่า (ถ้ามี)
        if ($announcement->img_path) {
            Storage::disk('public')->delete($announcement->img_path);
        }
        // 4. อัปโหลดรูปภาพใหม่และเก็บที่อยู่
        $data['img_path'] = $request->file('image')->store('announcements', 'public');
    }

    // 5. อัปเดตข้อมูลในฐานข้อมูล
    $announcement->update($data);

    // 6. Redirect กลับไปที่ Dashboard
    return redirect()->route('admin.dashboard')
                     ->with('success', 'ประกาศถูกแก้ไขเรียบร้อยแล้ว!');
}

// AnnounceController.php
public function destroy($id)
{
    $announcement = Announcement::findOrFail($id);
    $announcement->delete();


    return redirect()->route('admin.dashboard')
                     ->with('success', 'ลบประกาศเรียบร้อยแล้ว');
}



}
