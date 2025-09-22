@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <h3 class="fw-bold mb-4">ประวัติการยืม-คืนทั้งหมด</h3>

            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-0">
                    {{-- 1. ใช้ <ul> เพื่อสร้างรายการ --}}
                    <ul class="list-group list-group-flush">
                        {{-- 2. ใช้ @forelse เพื่อวน Loop ข้อมูลใน $loans --}}
                        @forelse ($loans as $loan)
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                
                                {{-- ส่วนแสดงข้อมูล --}}
                                <div class="flex-grow-1">
                                    <p class="fw-bold mb-1">
                                        {{ $loan->item->asset_code }} <span class="text-muted">({{ $loan->item->equip->equip_name }})</span>
                                    </p>
                                    <p class="small mb-1">
                                        ผู้ยืม: {{ $loan->user->name }}
                                    </p>
                                    <p class="small mb-0 text-muted">
                                        ยืมเมื่อ: {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y H:i น.') }}
                                        @if($loan->returned_at)
                                            | คืนเมื่อ: {{ \Carbon\Carbon::parse($loan->returned_at)->format('d M Y H:i น.') }}
                                        @endif
                                    </p>
                                </div>

                                {{-- ส่วนแสดงสถานะ --}}
                                <div>
                                    @if($loan->returned_at)
                                        <span class="badge bg-success">คืนแล้ว</span>
                                    @elseif($loan->pending_return_at)
                                        <span class="badge bg-warning text-dark">รอตรวจสอบ</span>
                                    @else
                                        <span class="badge bg-danger">ยังไม่คืน</span>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted p-5">
                                ยังไม่มีประวัติการยืม-คืนในระบบ
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- 3. เพิ่มส่วนแสดงปุ่มเปลี่ยนหน้า (Pagination) --}}
            <div class="mt-4">
                {{ $loans->links() }}
            </div>

        </div>
    </div>
</div>
@endsection