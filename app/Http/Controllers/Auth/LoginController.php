<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
{
    $input = $request->all();
    $this->validate($request, [
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {

        // 1. ตรวจสอบก่อนว่าเป็น super-admin หรือไม่
        if (auth()->user()->role == 'super-admin') {
            return redirect()->route('admin.dashboard'); // <-- เพิ่มส่วนนี้

        // 2. ถ้าไม่ใช่ ให้ตรวจสอบว่าเป็น admin หรือไม่
        } elseif (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard'); // <-- เปลี่ยนจาก if เป็น elseif

        // 3. ถ้าไม่ใช่ทั้งหมดข้างบน ก็เป็นสมาชิกทั่วไป
        } else {
            return redirect()->route('dashboard');
        }

    } else {
        return redirect()->route('login')->with('error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง');
    }
}

     public function showLoginForm()
    {
        // นี่คือฟังก์ชันที่เราเพิ่มเข้ามาเพื่อเขียนทับของเดิม
        // และชี้ไปยังไฟล์ Blade ที่เราสร้างขึ้นเอง
        return view('auth.custom-login');
    }
}
