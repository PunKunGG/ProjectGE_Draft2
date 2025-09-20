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

            {{-- START: ปรับปรุงส่วนหัวและปุ่ม --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                <h3 class="fw-bold mb-0">สรุปสต็อกอุปกรณ์</h3>
                <div>
                    <a href="{{ route('admin.add-item') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>เพิ่มสต็อก
                    </a>
                    <a href="{{ route('admin.items.bulk-update') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-tags me-2"></i>จัดการรายชิ้น
                    </a>
                </div>
            </div>
            {{-- END: ปรับปรุงส่วนหัวและปุ่ม --}}


            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        
                        @forelse ($equips as $equip)
                            {{-- START: เพิ่ม Logic การนับ --}}
                            @php
                                $statusCounts = $equip->items->countBy('status');
                                $totalCount = $equip->items->count();
                            @endphp
                            {{-- END: เพิ่ม Logic การนับ --}}

                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <span class="fw-bold fs-5">{{ $equip->equip_name }}</span>
                                    
                                    {{-- START: แสดงข้อมูลสรุป --}}
                                    <div class="small text-muted mt-1">
                                        หมวดหมู่ : {{ $equip->category->name }} |
                                        จำนวนทั้งหมด : <span class="fw-bold">{{ $totalCount }}</span>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        @foreach ($statuses as $status => $label)
                                            <span class="badge rounded-pill 
                                                @if($status == 'Available') bg-success
                                                @elseif($status == 'Borrowed') bg-warning text-dark
                                                @elseif($status == 'Maintenance') bg-info text-dark
                                                @else bg-danger @endif">
                                                {{ $label }}: {{ $statusCounts->get($status, 0) }}
                                            </span>
                                        @endforeach
                                    </div>
                                    {{-- END: แสดงข้อมูลสรุป --}}

                                </div>
                                
                                {{-- ส่วน Dropdown จัดการ "ประเภท" อุปกรณ์ (เหมือนเดิม) --}}
                                <div class="dropdown float-end">
                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    @foreach($items as $item)
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.edit-item', $item->id) }}">
                                                <i class="fas fa-edit me-2"></i>แก้ไข
                                            </a>
                                        </li>
                                        <li>
                                        <form action="{{ route('admin.delete-item', $item->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบประเภทอุปกรณ์นี้? การกระทำนี้จะลบไอเทมทั้งหมดที่อยู่ภายใต้ประเภทนี้ด้วย!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i>ลบประเภท
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                    @endforeach
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted p-4">
                                <p>ยังไม่มีประเภทอุปกรณ์ในระบบ</p>
                                <a href="{{ route('admin.equip.create') }}" class="btn btn-sm btn-primary">สร้างประเภทอุปกรณ์ใหม่</a>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection