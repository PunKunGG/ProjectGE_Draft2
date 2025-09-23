@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            {{-- ... ส่วน Header และ Search ... --}}

            @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($items as $item)
                            <li class="list-group-item d-flex align-items-center p-3">
                                <div class="flex-grow-1">
                                    <span class="fw-bold fs-5">{{ $item->asset_code }}</span>
                                    <p class="mb-1 text-muted">{{ $item->equip->equip_name }}</p>
                                </div>
                                
                                {{-- START: Logic การแสดงปุ่ม --}}
                                <div>
                                    @if ($item->status == 'Available')
                                        {{-- 1. ถ้าของ Available: แสดงปุ่ม "ยืม" --}}
                                        <form action="{{ route('equipLoan.store') }}" method="POST" onsubmit="return confirm('คุณต้องการยืม {{ $item->asset_code }} ใช่หรือไม่?');">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-success btn-sm">ยืม</button>
                                        </form>

                                    @elseif (in_array($item->id, $myLoanItemIds))
                                        {{-- 2. ถ้าของถูกยืม "โดยเรา": แสดงปุ่ม/สถานะ "แจ้งคืน" --}}
                                        @php
                                            // ค้นหา loan record ของไอเทมนี้เพื่อเช็คสถานะการแจ้งคืน
                                            $loan = auth()->user()->equipLoans->firstWhere('item_id', $item->id);
                                        @endphp

                                        @if ($loan && is_null($loan->pending_return_at))
                                            {{-- ยังไม่ได้แจ้งคืน: แสดงฟอร์มแจ้งคืน --}}
                                            <form action="{{ route('equipLoan.requestReturn', $loan->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="input-group input-group-sm">
                                                    <input type="file" name="return_photo" class="form-control" required>
                                                    <button type="submit" class="btn btn-info">แจ้งคืน</button>
                                                </div>
                                            </form>
                                        @else
                                            {{-- แจ้งคืนไปแล้ว: แสดงสถานะรอดำเนินการ --}}
                                            <span class="badge bg-secondary">รอกรรมการตรวจสอบ</span>
                                        @endif

                                    @else
                                        {{-- 3. ถ้าของมีสถานะอื่น (เช่น ถูกยืมโดยคนอื่น): แสดงเป็นปุ่ม Disabled --}}
                                        <button class="btn btn-warning btn-sm text-dark" disabled>
                                            {{ \App\Models\Item::STATUS_OPTIONS[$item->status] }}
                                        </button>
                                    @endif
                                </div>
                                {{-- END: Logic การแสดงปุ่ม --}}
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted p-5">ไม่มีไอเทมพร้อมให้ยืม</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection