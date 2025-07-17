@extends('layouts.master')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Bài viết mới nhất</h2>

    <div class="row">
        @forelse ($posts as $post)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="ratio ratio-16x9">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top object-fit-cover" alt="{{ $post->title }}" style="object-fit: cover;">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text text-muted small">
                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}
                    </p>
                    <div class="mt-auto">
                        <a href="{{ route('client.blog.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Đọc tiếp</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">Chưa có bài viết nào.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
