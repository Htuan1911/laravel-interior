@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold">
                Chi tiết thuộc tính: <span class="text-warning">{{ $option->name }}</span>
            </h3>
            <a href="{{ route('admin.product_options.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <p><strong>Danh mục:</strong> {{ $category->name ?? 'Chưa xác định' }}</p>
            <p><strong>Trạng thái:</strong>
                <span class="badge {{ strtolower($option->status) === 'active' ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($option->status) }}
                </span>
            </p>

            <h5 class="mt-4 mb-3">Giá trị thuộc tính</h5>
            @if($optionValues->isEmpty())
                <p class="text-muted">Không có giá trị nào.</p>
            @else
                <div class="d-flex flex-wrap gap-3">
                    @foreach ($optionValues as $val)
                        <span class="badge rounded-pill d-flex align-items-center gap-2 px-3 py-2 border border-secondary" style="background: #fefefe; color: #212529;">
                            @if (!empty($val->color_code))
                                <span class="color-circle" style="background-color: {{ $val->color_code }};"></span>
                            @endif
                            <span class="fw-semibold">{{ $val->value ?? '[Không có giá trị]' }}</span>
                            <small class="text-muted">(Loại: {{ ucfirst($val->type) }})</small>
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.color-circle {
    display: inline-block;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 1px solid #ccc;
}
</style>
@endsection
