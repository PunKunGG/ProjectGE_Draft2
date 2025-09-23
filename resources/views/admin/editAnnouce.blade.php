@extends('layouts.new_app')

@section('new_content')
    <div class="card rounded-3 shadow-sm">
    <div class="card-body p-4">

         <form action="{{ route('admin.update-announce', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- 2. เพิ่ม @method('PUT') สำหรับการอัปเดต --}}

                        {{-- กล่องข้อความ --}}
                        <div class="mb-3">
                            <label for="announcement-text" class="form-label fw-bold">ข้อความประกาศ</label>
                            {{-- 3. ดึงข้อมูลเดิมมาใส่ใน textarea --}}
                            <textarea class="form-control" name="message" rows="4">{{ old('message', $announcement->message) }}</textarea>
                        </div>

                        {{-- แสดงรูปภาพปัจจุบัน (ถ้ามี) --}}
                        @if ($announcement->img_path)
                            <div class="mb-2">
                                <p class="fw-bold">รูปภาพปัจจุบัน:</p>
                                <img src="{{ asset('storage/' . $announcement->img_path) }}" alt="Current Image" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        @endif

                        {{-- ปุ่มสำหรับเลือกรูปภาพใหม่ --}}
                        <div class="mb-3">
                            <label for="image-upload" class="btn btn-secondary">
                                <i class="fas fa-camera"></i> เปลี่ยนรูปภาพ (เลือกถ้าต้องการเปลี่ยน)
                            </label>
                            <input type="file" id="image-upload" name="image" accept="image/*" style="display: none;">
                        </div>

                            {{-- รูป preview (ไว้โชว์ก่อนบันทึก) --}}
                            <img id="image-preview" src="#" 
                                alt="รูปภาพใหม่" 
                                class="img-fluid rounded mb-3" 
                                style="display: none; max-height: 200px;">

                        <hr>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลง
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