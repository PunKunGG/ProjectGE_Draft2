@extends('layouts.new_app')
@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

@if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
{{-- ใช้ @forelse ตั้งแต่ต้น --}}
@forelse ($users as $user)
<li class="list-group-item d-flex justify-content-between align-items-center">
    <div>
        <strong>{{ $user->name }}</strong><br>
        <span class="text-muted">Role ปัจจุบัน: {{ $user->role }}</span>
    </div>
    <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="input-group">
            <select name="role" class="form-select">
                <option value="member" @if($user->role == 'member') selected @endif>Member</option>
                <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
        </div>
    </form>
</li>

{{-- ไม่ต้องมี @endforeach ตรงนี้ --}}

@empty
    <li class="list-group-item text-center text-muted p-5">ยังไม่มีสมาชิก</li>
@endforelse {{-- ปิดท้ายด้วย @endforelse --}}

@endsection
</div>
</div>
</div>