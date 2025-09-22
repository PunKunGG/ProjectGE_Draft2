@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <h3 class="fw-bold mb-4">ประวัติการยืม-คืนของฉัน</h3>

            <div class="card rounded-3 shadow-sm">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($loans as $loan)
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                
                                <div class="flex-grow-1">
                                    <p class="fw-bold mb-1">{{ $loan->item->asset_code }} <span class="text-muted">({{ $loan->item->equip->equip_name }})</span></p>
                                    <p class="small mb-0 text-muted">
                                        ยืมเมื่อ: {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y H:i น.') }}
                                        @if($loan->returned_at)
                                            | คืนเมื่อ: {{ \Carbon\Carbon::parse($loan->returned_at)->format('d M Y H:i น.') }}
                                        @endif
                                    </p>
                                </div>

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
                            <li class="list-group-item text-center text-muted p-5">คุณยังไม่มีประวัติการยืม-คืน</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                {{ $loans->links() }}
            </div>

        </div>
    </div>
</div>
@endsection