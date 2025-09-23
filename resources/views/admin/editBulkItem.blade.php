@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">จัดการไอเทมรายชิ้น</h3>
                 <div>
                    <a href="{{ route('admin.add-item') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>เพิ่มสต็อก
                    </a>
                    <a href="{{ route('admin.item') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-tags me-2"></i>กลับไปหน้าสรุป
                    </a>
                </div>
            </div>

             <form action="{{route('admin.items.bulk-edit')}}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ค้นหาอุปกรณ์..." value="{{request('search')}}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> ค้นหา
                    </button>
                </div>
            </form>
            
            {{-- 1. สร้างฟอร์มใหญ่ครอบรายการทั้งหมด --}}
            <form action="{{ route('admin.items.bulk-update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card rounded-3 shadow-sm">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($items as $item)
                                <li class="list-group-item d-flex align-items-center p-3">
                                    {{-- 2. เพิ่ม Checkbox --}}
                                    <div class="me-3">
                                        <input class="form-check-input" type="checkbox" name="item_ids[]" value="{{ $item->id }}"
                                        {{$item->status == 'Borrowed'?'disabled':''}}
                                        >
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-bold fs-5">{{ $item->asset_code }}</span>
                                        <p class="mb-1 text-muted">{{ $item->equip->equip_name }}</p>
                                        <p class="mb-1">{{ $item->status }}</p>
                                    </div>
                                    {{-- ... Dropdown แก้ไขรายชิ้น (เหมือนเดิม) ... --}}
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted p-5">ยังไม่มีไอเทมในระบบ</li>
                            @endforelse
                        </ul>
                    </div>
                    
                    {{-- 3. เพิ่มส่วนสำหรับ Bulk Actions ที่ท้าย Card --}}
                    @if($items->isNotEmpty())
                    <div class="card-footer bg-light p-3">
                        <div class="d-flex align-items-center gap-3">
                            <label for="bulk_status" class="form-label fw-bold mb-0">สำหรับรายการที่เลือก:</label>
                            <select name="status" id="bulk_status" class="form-select w-auto" required>
                                <option value="" selected disabled>--เปลี่ยนสถานะเป็น--</option>
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">ยืนยันการเปลี่ยนแปลง</button>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection