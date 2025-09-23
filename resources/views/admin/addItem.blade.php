@extends('layouts.new_app')

@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card rounded-3 shadow-sm">
                <div class="card-header"><h3 class="fw-bold mb-0">เพิ่มสต็อกจำนวนมาก (สร้างรหัสอัตโนมัติ)</h3></div>
                <div class="card-body p-4">

                    {{-- ... โค้ดแสดง Error และ Success ... --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.item-store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="equip_id" class="form-label fw-bold">อุปกรณ์</label>
                            <select id="equip_id" name="equip_id" class="form-select" required>
                                <option value="" selected disabled>-- กรุณาเลือก --</option>
                                @foreach ($equips as $equip)
                                    <option value="{{ $equip->id }}" data-prefix="{{ $equip->prefix }}">{{ $equip->equip_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prefix" class="form-label fw-bold">รหัสนำหน้า (Prefix)</label>
                            <input type="text" id="prefix_display" class="form-control" value="{{ $equip->prefix }}" disabled>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label fw-bold">จำนวนที่ต้องการเพิ่ม</label>
                                <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold">สถานะ</label>
                                <select name="status" class="form-select" required>
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary fw-bold">สร้างไอเทมทั้งหมด</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const equipSelected = document.getElementById('equip_id');
    const prefixDisplay = document.getElementById('prefix_display');
    equipSelected.addEventListener('change',function(){
        const selectedOption = this.options[this.selectedIndex];
        const prefix = selectedOption.getAttribute('data-prefix');
        prefixDisplay.value = prefix || '--';
    })
</script>
@endsection