@extends('layouts.new_app')
@section('new_content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            {{-- แสดงข้อความ Success เมื่อยืนยันสำเร็จ --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h3 class="fw-bold mb-4">รายการรอตรวจสอบการคืน</h3>

            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($loans as $loan)
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3 gap-3">
                                
                                {{-- 1. ส่วนข้อมูลการยืม --}}
                                <div class="flex-grow-1">
                                    <span class="fw-bold fs-5">{{ $loan->item->asset_code }}</span>
                                    <p class="text-muted mb-1">{{ $loan->item->equip->equip_name }}</p>
                                    <p class="mb-0">
                                        <i class="fas fa-user me-2"></i>ผู้ยืม: <strong>{{ $loan->user->name }}</strong>
                                    </p>
                                    <p class="mb-0 small text-primary">
                                        <i class="fas fa-clock me-2"></i>เวลาที่แจ้งคืน: {{ \Carbon\Carbon::parse($loan->pending_return_at)->format('d M Y H:i น.') }}
                                    </p>
                                </div>

                                {{-- 2. ส่วนแสดงรูปถ่าย --}}
                                <div class="text-center">
                                    @if($loan->return_photo_path)
                                        <a href="{{ asset('storage/' . $loan->return_photo_path) }}" target="_blank" title="คลิกเพื่อดูภาพขยาย">
                                            <img src="{{ asset('storage/' . $loan->return_photo_path) }}" alt="Return Photo" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                        </a>
                                    @else
                                        <span class="text-muted">ไม่มีรูปภาพ</span>
                                    @endif
                                </div>

                                {{-- 3. ส่วนปุ่มสำหรับ "ยืนยันการรับคืน" --}}
                                <div>
                                    <form action="{{route('admin.loans.confirmReturn',$loan->id)}}" method="POST" onsubmit="return confirm('ยืนยันการรับคืน{{$loan->item->asset_code}}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check-double me-2"></i>ยืนยัน
                                        </button>
                                    </form>
                                     </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted p-5">
                                ไม่มีรายการรอตรวจสอบในขณะนี้
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection