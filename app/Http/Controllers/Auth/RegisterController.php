<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users,email',  'regex:/^[a-zA-Z0-9]+\.[a-zA-Z0-9]+@kkumail\.com$/'],
            'phone' => ['required','regex:/^0[0-9]{9}$/','unique:users,phone'],
            'studentId' => ['required', 'regex:/^\d{9}-\d{1}$/', 'unique:users,studentId'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showRegistrationForm()
    {
        // นี่คือฟังก์ชันที่เราเพิ่มเข้ามาเพื่อเขียนทับของเดิม
        // และชี้ไปยังไฟล์ Blade ที่เราสร้างขึ้นเอง
        return view('auth.custom-register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'studentId' => $data['studentId'],
            'password' => Hash::make($data['password']),
        ]);
    }

     protected function redirectTo()
    {
        // ตรวจสอบ role ของผู้ใช้ที่เพิ่งสมัครและล็อกอิน
        if (auth()->user()->is_admin) {
            return '/admin/dashboard';
        }

        return '/dashboard';
    }
}
