@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h3 class="fw-bold mb-4">รายการยืมที่ยังไม่คืน</h3>

            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($equipLoans as $equipLoan)
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                
                                {{-- ส่วนข้อมูลการยืม --}}
                                <div class="flex-grow-1">
                                    <span class="fw-bold fs-5">{{ $equipLoan->item->asset_code }}</span>
                                    <p class="text-muted mb-1">{{ $equipLoan->item->equip->equip_name }}</p>
                                    <p class="mb-0">
                                        <i class="fas fa-user me-2"></i>ผู้ยืม: <strong>{{ $equipLoan->user->name }}</strong>
                                    </p>
                                    <p class="mb-0 small">
                                        <i class="fas fa-calendar-day me-2"></i>วันที่ยืม: {{ \Carbon\Carbon::parse($equipLoan->created_at)->format('d M Y') }}
                                    </p>
                                    <p class="mb-0 small text-danger">
                                        <i class="fas fa-calendar-times me-2"></i>กำหนดคืน: {{ \Carbon\Carbon::parse($equipLoan->due_date)->format('d M Y') }}
                                    </p>
                                </div>

                                {{-- ส่วนปุ่มสำหรับ "รับคืน" --}}
                                <div>
                                    <form action="{{ route('admin.equipLoan.return', $equipLoan->id) }}" method="POST" onsubmit="return confirm('ยืนยันการรับคืน {{ $equipLoan->item->asset_code }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle me-2"></i>รับคืน
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted p-5">
                                ไม่มีรายการยืมค้างในระบบ
                            </li>
                        @endourse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection