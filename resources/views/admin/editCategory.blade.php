@extends('layouts.new_app')

@section('new_content')
    <div class="card rounded-3 shadow-sm">
    <div class="card-body p-4">

         <form action="{{ route('admin.update-category', $category->id) }}" method="POST" >
                        @csrf
                        @method('PUT') 
                        <div class="mb-3">
                            <label for="category_name" class="form-label fw-bold">ชื่อหมวดหมู่</label>
                            {{-- 3. ดึงข้อมูลเดิมมาใส่ใน textarea --}}
                             <input type="text" class="form-control" id="category-name" name="name" value="{{ old('name', $category->name) }}" required>
                        </div>

                         <hr>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลง
                        </button>
                    </form>
    </div>
</div>

@endsection