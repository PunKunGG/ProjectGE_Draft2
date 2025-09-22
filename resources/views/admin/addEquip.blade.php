@extends('layouts.new_app')
@section('new_content')
<div class="card rounded-3 shadow-sm">
    <div class="card-body  p-4">
        
        <form action="{{route('admin.equip-store')}}" method="POST">
            @csrf
            
                <h3 class="fw-bold mb-3">เพิ่มรายชื่ออุปกรณ์</h3>

                @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
            <div class="mb-3">
                <label for="equip_name" class="form-label fw-bold">ชื่ออุปกรณ์</label>
                <input type="text" class="form-control" id="equip_name" name="equip_name" required>
            </div>
             <div class="mb-3">
                <label for="prefix" class="form-label fw-bold">รหัสอุปกรณ์</label>
                <input type="text" class="form-control" id="prefix" name="prefix"  value="{{ old('prefix') }}" placeholder="เช่น RC, BB, ARR" required>
            </div>
            @error('prefix')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
            <div class="mb-3">
                <label for="category_id" class="form-label fw-bold" >หมวดหมู่</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">กรุณาเลือกหมวดหมู่</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                </select>
            </div> 
            <hr>
            

            <button type="submit" class="btn btn-primary fw-bold">
                <i class="fas fa-save"></i> บันทึก
            </button>
            <a href="{{ route('admin.equip') }}" class="btn btn-secondary fw-bold">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
            </a>

        </form>
    </div>
</div>


@endsection