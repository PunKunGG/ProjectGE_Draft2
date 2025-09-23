@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">

    {{-- ส่วนหัวข้อและปุ่มบวก --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="display-5 fw-bold dashboard-header">จัดการหมวดหมู่</h1>
        {{-- ปุ่มบวกนี้อาจจะไม่จำเป็นแล้ว ถ้าฟอร์มอยู่ข้างๆ --}}
    </div>

    {{-- แสดงข้อความ Success Message (ถ้ามี) --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        {{-- คอลัมน์ซ้าย: แสดงรายการหมวดหมู่ทั้งหมด --}}
        <div class="col-md-7">
            <div class="card rounded-3 shadow-sm">
                <div class="card-header fw-bold">
                    รายการหมวดหมู่ทั้งหมด
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        {{-- ======================================================= --}}
                        {{-- == นี่คือส่วนที่ขาดไป: วนลูปแสดงผล $categories == --}}
                        {{-- ======================================================= --}}
                        @forelse ($categories as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                  <div class="dropdown float-end">
                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i> {{-- ไอคอนสามจุด --}}
                                    </button>
                                <ul class="dropdown-menu">
                    
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.edit-category', $category->id) }}">
                                        <i class="fas fa-edit me-2"></i>แก้ไข
                                        </a>
                                    </li>
                    
                                    <li>
                                    <form action="{{ route('admin.delete-category',  $category->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบหมวดหมู่นี้?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-2"></i>ลบ
                                        </button>
                                    </form>
                                    </li>
                                </ul>
                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">ยังไม่มีหมวดหมู่</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- คอลัมน์ขวา: ฟอร์มสำหรับเพิ่มหมวดหมู่ใหม่ --}}
        <div class="col-md-5">
            <div class="card rounded-3 shadow-sm">
                <div class="card-header fw-bold">
                    เพิ่มหมวดหมู่ใหม่
                </div>
                <div class="card-body p-4">
                    {{-- แก้ไขฟอร์มให้ถูกต้อง --}}
                    <form action="{{ route('admin.category-store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="category-name" class="form-label">ชื่อหมวดหมู่</label>
                            <input type="text" class="form-control" id="category-name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-save"></i> บันทึก
                        </button>
                        <a href="{{ route('admin.equip') }}" class="btn btn-secondary fw-bold">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection