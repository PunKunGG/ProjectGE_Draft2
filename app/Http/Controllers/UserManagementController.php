<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    //
     public function index()
    {
        // ดึงผู้ใช้ทั้งหมด ยกเว้น Super Admin คนปัจจุบัน เพื่อไม่ให้ลดตำแหน่งตัวเอง
        $users = User::where('id', '!=', auth()->id())->get();
        return view('superadmin.users', ['users' => $users]);
    }

    // อัปเดต Role ของผู้ใช้
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,member', // กำหนดให้เปลี่ยนได้แค่ 2 สถานะนี้
        ]);

        // ป้องกันการเปลี่ยน Role ของ Super Admin คนอื่น (ถ้ามี)
        if ($user->role === 'super-admin') {
            return redirect()->back()->with('error', 'ไม่สามารถเปลี่ยนแปลงสิทธิ์ของ Super Admin ได้');
        }

        $user->update(['role' => $request->role]);

        return redirect()->route('users.index')->with('success', 'อัปเดตสิทธิ์ของ ' . $user->name . ' เรียบร้อยแล้ว');
    }
}
