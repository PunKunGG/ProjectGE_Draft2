@extends('layouts.new_app')

@section('new_content')

 {{-- 1. สร้าง container หลักเพียงอันเดียวครอบทุกอย่าง --}}
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">

            {{-- 2. ย้าย Title "Dashboard" มาไว้ข้างใน Grid --}}
            <div class="card-header display-5 fw-bold dashboard-header ms-2 p-2">{{ __('Dashboard') }}</div>
 

            {{-- 3. Card เนื้อหาจะอยู่ต่อจาก Title ในคอลัมน์เดียวกัน --}}
            <div class="card rounded-3 shadow-sm ms-3">
                <div class="card-body p-4">
                    
                    {{-- กล่องข้อมูลผู้ใช้ --}}
                    <div class="container p-2 rounded container-user">
                        {{ Auth::user()->studentId }} {{ Auth::user()->name }}
                    </div>
                    <h3 class="p-2 h-position" >@if (Auth::user()->role == 'admin')
                        <p><strong>ตำแหน่ง :</strong> กรรมการ</p>
                    @else
                        <p><strong>ตำแหน่ง :</strong> สมาชิกชมรม</p>
                    @endif</h3>
                </div>
                </div>

                <div class="card-header display-5 fw-bold dashboard-header ms-2 p-2">
                    <h3 class="p-2 h-position">
                        {{-- ตรวจสอบว่ามีการยืมอุปกรณ์หรือไม่ --}}
            @if(!$loans->isEmpty())
                <div class="card rounded-3 shadow-sm mt-4">
                    <div class="card-body p-4">
                        <p class="h5">
                            <strong>อุปกรณ์ที่ยืม :</strong>

                            {{-- วนลูปแสดงรายการอุปกรณ์ที่ยืม --}}
                            @foreach ($loans as $loan)
                                {{ $loan->equip->equip_name }} x {{ $loan->quantity }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            @endif
                    </h3>

                </div>

                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-lg-8 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center announcement-box flex-grow-1">
                            <img src="{{ asset('img/Loudspeaker Emoji.png') }}" 
                                    alt="megaphone" class="megaphone-icon me-2">
                                    <span class="fw-bold fs-4">ประกาศ</span>
                            <img src="{{ asset('img/Loudspeaker Emoji.png') }}" 
                                    alt="megaphone" class="megaphone-icon ms-2">
                        </div>
                            <a href="{{ route('admin.add-announce') }}" class="btn btn-add-announcement ms-3">
                                <i class="fas fa-plus"></i>
                            </a>
                    </div>
                </div>

                <div class="card rounded-3 shadow-sm ms-3">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- วนลูปแสดงผลประกาศ --}}
                    @foreach ($announcements as $announcement)
                        <div class="card rounded-3 shadow-sm mt-4">
                            <div class="card-body p-4">

                                 <div class="dropdown float-end">
                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i> {{-- ไอคอนสามจุด --}}
                </button>
                <ul class="dropdown-menu">
                    {{-- 1. เมนูแก้ไข --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.edit-announce', $announcement->id) }}">
                            <i class="fas fa-edit me-2"></i>แก้ไข
                        </a>
                    </li>
                    {{-- 2. เมนูลบ (ใช้ฟอร์มเพื่อความปลอดภัย) --}}
                    <li>
                        <form action="{{ route('admin.delete-announce',  $announcement->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบประกาศนี้?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-trash me-2"></i>ลบ
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

                                {{-- แสดงรูปภาพ (ถ้ามี) --}}
                                @if ($announcement->img_path)
                                <img src="{{ asset('storage/' . $announcement->img_path) }}" class="img-fluid rounded mb-3" alt="Announcement Image">
                                @endif

                                {{-- แสดงข้อความประกาศ --}}
                                <p class="announcement-text" id="text-{{ $announcement->id }}">
                                    {{ $announcement->message }}
                                </p>
                                <a href="javascript:void(0);" 
                                   class="read-more-btn" 
                                   data-id="{{ $announcement->id }}">
                                   อ่านเพิ่มเติม
                                </a>
                                <small class="text-muted">ประกาศเมื่อ: {{ $announcement->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>

        </div>
    </div>
</div>

        <script>
    document.querySelectorAll('.read-more-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const text = document.getElementById('text-' + id);
        text.classList.toggle('expanded');

        if(text.classList.contains('expanded')){
            this.textContent = "ย่อข้อความ";
        }else{
            this.textContent = "อ่านเพิ่มเติม";
        }
    });
});

</script>
@endsection

