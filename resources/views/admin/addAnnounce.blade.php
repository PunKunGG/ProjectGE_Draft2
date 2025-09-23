@extends('layouts.new_app')

@section('new_content')
    <div class="card rounded-3 shadow-sm">
    <div class="card-body p-4">

        {{-- ฟอร์มนี้จะส่งข้อมูลไปที่ Route 'announcements.store' --}}
        <form action="{{ route('admin.announce-store')}}#" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 1. กล่องข้อความ --}}
            <div class="mb-3">
                <label for="announcement-text" class="form-label fw-bold">ข้อความประกาศ</label>
                <textarea class="form-control" id="announcement-text" name="message" rows="4" placeholder="พิมพ์ข้อความประกาศที่นี่..."></textarea>
            </div>

            {{-- 2. พื้นที่สำหรับแสดงรูปภาพตัวอย่าง --}}
            <img id="image-preview" src="#" alt="รูปภาพตัวอย่าง" class="img-fluid rounded mb-3" style="display: none; max-height: 300px;">

            {{-- 3. ปุ่มสำหรับเลือกรูปภาพ --}}
            <div class="mb-3">
                <label for="image-upload" class="btn btn-secondary">
                    <i class="fas fa-camera"></i> เพิ่มรูปภาพ
                </label>
                <input type="file" id="image-upload" name="image" accept="image/*" style="display: none;">
                @error('image')
            <div class="invalid-feedback d-block"> {{-- d-block ทำให้แสดงผลได้ --}}
                {{ $message }}
            </div>
        @enderror
            </div>

            <hr>

            {{-- 4. ปุ่มบันทึก --}}
            <button type="submit" class="btn btn-primary fw-bold">
                <i class="fas fa-save"></i> บันทึกประกาศ
            </button>

        </form>

    </div>
</div>

<script>
    // 1. หา element ของ input ที่ใช้เลือกไฟล์ และ img ที่จะใช้แสดงผล
    const imageUploadInput = document.getElementById('image-upload');
    const imagePreviewElement = document.getElementById('image-preview');

    // 2. สร้าง "Event Listener" เพื่อดักฟังว่าผู้ใช้เลือกไฟล์เมื่อไหร่
    imageUploadInput.addEventListener('change', function () {
        
        // 3. เมื่อผู้ใช้เลือกไฟล์แล้ว ให้เริ่มกระบวนการอ่านไฟล์
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            // 4. เมื่ออ่านไฟล์เสร็จเรียบร้อย
            reader.onload = function(e) {
                // 5. นำข้อมูลรูปภาพที่ได้ไปใส่ใน src ของ <img>
                imagePreviewElement.src = e.target.result;
                
                // 6. สั่งให้ <img> แสดงผลขึ้นมา (จากเดิมที่ display: none)
                imagePreviewElement.style.display = 'block';
            };

            // 7. เริ่มต้นอ่านไฟล์ที่ผู้ใช้เลือก
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection