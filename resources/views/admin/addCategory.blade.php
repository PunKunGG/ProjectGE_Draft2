@extends('layouts.new_app')
@section('new_content')
<div class="card rounded-3 shadow-sm">
    <div class="card-body  p-4">
        <form action="">

        
        </form>
        <form action="{route{('admin.category-store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="add-equip" class="form-label fw-bold">เพิ่มหมวดหมู่อุปกรณ์</label>
                <label for="equip_name" class="form-label fw-bold">ชื่อหมวดหมู่</label>
                <input type="text" name="category_name">
            </div>

            <button type="submit" class="btn btn-primary fw-bold">
                <i class="fas fa-save"></i> บันทึก
            </button>

        </form>
    </div>
</div>


@endsection