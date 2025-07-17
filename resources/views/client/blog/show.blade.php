@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Thông tin bài viết -->
            <div class="card shadow-sm border-0">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top img-fluid" alt="{{ $post->title }}">
                
                <div class="card-body p-4">
                    <h1 class="card-title mb-3">{{ $post->title }}</h1>
                    
                    <div class="text-muted mb-4">
                        <small>Ngày đăng: {{ $post->created_at->format('d/m/Y') }}</small>
                    </div>
                    
                    <div class="card-text fs-5" style="line-height: 1.8;">
                        {!! $post->content !!}
                    </div>

                    <a href="{{ route('client.blog.index') }}" class="btn btn-outline-secondary mt-4">
                        ← Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
