@extends('layouts.new_app')
@section('new_content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card-header display-5 fw-bold equiploan-header ms-2 p-2">{{__('ยืม-คืน อุปกรณ์')}}</div>

            <form action="{{route('equipLoan')}}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ค้นหาอุปกรณ์..." value="{{request('search')}}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> ค้นหา
                    </button>
                </div>
            </form>

            <div class="card-body">
                <ul class="list-group list-group-flush">
                     @forelse ($equips as $equip)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">{{ $equip->equip_name }}</span>
                                    <span class="text-muted"> จำนวน : {{$equip->quantity}}</span>

                                    <div class="small text-muted">
                                        หมวดหมู่ :  {{ $equip->category->name }}
                                    </div>
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