@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chỉnh sửa bài viết</h2>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="PUT" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}">
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ $post->slug }}">
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="5">{{ $post->content }}</textarea>
        </div>

        <div class="mb-3">
            <label>Hình ảnh hiện tại:</label><br>
            @if($post->thumbnail)
                <img src="{{ asset('storage/' . $post->thumbnail) }}" width="150">
            @endif
            <br><label>Chọn hình ảnh mới:</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <div class="mb-3">
            <label>Danh mục</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Nháp</option>
                <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Xuất bản</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
<script>
    function slugify(str) {
        return str
            .toLowerCase()
            .trim()
            .normalize('NFD')                         // loại bỏ dấu tiếng Việt
            .replace(/[\u0300-\u036f]/g, '')          // loại bỏ ký tự đặc biệt
            .replace(/[^a-z0-9 -]/g, '')              // loại bỏ ký tự không hợp lệ
            .replace(/\s+/g, '-')                     // thay khoảng trắng bằng dấu -
            .replace(/-+/g, '-');                     // loại bỏ dấu - thừa
    }

    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.querySelector('input[name="slug"]');

        titleInput.addEventListener('input', function () {
            slugInput.value = slugify(titleInput.value);
        });
    });
</script>
@endsection
