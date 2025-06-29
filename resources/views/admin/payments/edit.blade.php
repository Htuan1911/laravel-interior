@extends('layouts.admin')

@section('title', 'Cập nhật thanh toán')

@section('content')
    <h1>Cập nhật thanh toán #{{ $payment->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ $payment->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
