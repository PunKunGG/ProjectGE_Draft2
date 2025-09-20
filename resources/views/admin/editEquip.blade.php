@extends('layouts.new_app')

@section('new_content')
    <div class="card rounded-3 shadow-sm">
    <div class="card-body p-4">

         <form action="{{ route('admin.update-equip', $equip->id) }}" method="POST" >
                        @csrf
                        @method('PUT') 
                        <div class="mb-3">
                            <label for="equip_name" class="form-label fw-bold">ชื่ออุปกรณ์</label>
                            <input type="text" class="form-control" id="equip_name" name="equip_name" value="{{ old('equip_name', $equip->equip_name) }}" required>
                        </div>
            
            <div class="mb-3 ">
                <label for="category_id" class="form-label fw-bold" >หมวดหมู่</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">กรุณาเลือกหมวดหมู่</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(old('category_id', $equip->category_id) == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                        @endforeach
                </select>
            </div>    
           
             <hr>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลง
                        </button>
                    </form>
    </div>
</div>

@endsection