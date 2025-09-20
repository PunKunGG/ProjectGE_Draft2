@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card rounded-3 shadow-sm">
                <div class="card-header">
                    <h3 class="fw-bold mb-0">แก้ไขไอเทม</h3>
                </div>
                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.update-item', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- แสดงประเภทอุปกรณ์ (แก้ไขไม่ได้) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">ประเภทอุปกรณ์</label>
                            <input type="text" class="form-control" value="{{ $item->equip->equip_name }}" disabled>
                        </div>

                        {{-- 1. ทำให้ Asset Code แก้ไขได้ --}}
                        <div class="mb-3">
                            <label for="asset_code" class="form-label fw-bold">Asset Code (รหัสทรัพย์สิน)</label>
                            <input type="text" name="asset_code" id="asset_code" class="form-control" 
                                   value="{{ old('asset_code', $item->asset_code) }}" required>
                        </div>

                        {{-- 2. Dropdown สำหรับแก้ไขสถานะ (เหมือนเดิม) --}}
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">สถานะ</label>
                            <select name="status" id="status" class="form-select" required>
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" @if(old('status', $item->status) == $value) selected @endif>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.item') }}" class="btn btn-secondary">ย้อนกลับ</a>
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="fas fa-save me-2"></i>อัปเดตข้อมูล
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection