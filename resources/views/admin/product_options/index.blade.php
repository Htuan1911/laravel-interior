@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Danh sách thuộc tính sản phẩm</h4>
        <a href="{{ route('admin.product_options.create') }}" class="btn btn-primary">+ Thêm thuộc tính</a>
        <a href="{{ route('admin.product_options.trashed') }}" class="btn btn-outline-dark btn-sm">Xem danh sách đã xóa</a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($options->isEmpty())
        <div class="alert alert-info">Chưa có thuộc tính nào được tạo.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên thuộc tính</th>
                    <th>Loại</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Giá trị</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($options as $index => $option)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $option->name }}</td>
                        <td>{{ ucfirst($option->type) }}</td>
                        <td>{{ $option->category_name ?? 'Không xác định' }}</td>
                        <td>
                            @if($option->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            @if($option->values->isEmpty())
                                <span class="text-muted fst-italic">Chưa có giá trị</span>
                            @else
                                <ul class="list-unstyled mb-0">
                                    @foreach($option->values as $value)
                                        <li>
                                            {{ $value->value }}
                                            @if($option->type === 'color' && $value->color_code)
                                                <span style="display:inline-block;width:14px;height:14px;margin-left:5px;border:1px solid #ccc;background-color:{{ $value->color_code }};"></span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                          
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.product_options.edit', $option->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                            <form action="{{ route('admin.product_options.destroy', $option->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Bạn có chắc muốn xoá thuộc tính này không?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
