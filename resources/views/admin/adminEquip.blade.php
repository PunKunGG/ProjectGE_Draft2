@extends('layouts.new_app')

@section('new_content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-lg-8 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center announcement-box flex-grow-1">
                                    <span class="fw-bold fs-4 ms-4">จัดการอุปกรณ์</span>
                        </div>
                            <a href="{{ route('admin.add-equip') }}" class="btn btn-add-equip ms-3">
                                <i class="fas fa-plus"></i>
                            </a>
                           <a href="{{ route('admin.category') }}" class="btn btn-primary fw-bold">
                            <i class="fas "></i> จัดการหมวดหมู่
                        </a>
                    </div>
                </div>
               <div class="card-body">
                    <ul class="list-group list-group-flush">
                       
                        @forelse ($equips as $equip)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">{{ $equip->equip_name }}</span>
                                    

                                    <div class="small text-muted">
                                        หมวดหมู่ :  {{ $equip->category->name }}
                                    </div>

                                    <div class="small text-muted">
                                        รหัสอุปกรณ์ :  {{ $equip->prefix }}
                                    </div>
                                </div>
                                
                                <div class="dropdown float-end">
                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i> {{-- ไอคอนสามจุด --}}
                                    </button>
                                <ul class="dropdown-menu">
                    
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.edit-equip', $equip->id) }}">
                                        <i class="fas fa-edit me-2"></i>แก้ไข
                                        </a>
                                    </li>
                    
                                    <li>
                                    <form action="{{ route('admin.delete-equip',  $equip->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบอุปกรณ์นี้?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-2"></i>ลบ
                                        </button>
                                    </form>
                                    </li>
                                </ul>
                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">ยังไม่มีหมวดหมู่</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>




@endsection