@extends('layouts.blog')

@section('contentblog')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Thông tin bài viết -->
                <div class="card shadow-sm border-0">
                    <div class="hover-after p-4">
                        <img src="{{ asset($post->thumbnail) }}" class="card-img-top img-fluid rounded"
                            alt="{{ $post->title }}">
                    </div>

                    <div class="card-body p-4">
                        <h1 class="card-title mb-3">{{ $post->title }}</h1>

                        <div class="text-muted mb-4">
                            <small>Ngày đăng: {{ $post->created_at->format('d/m/Y') }}</small>
                        </div>

                        <div class="card-text fs-5 mb-4" style="line-height: 1.8;">
                            {!! $post->content !!}
                        </div>

                        <!-- Thông tin chi tiết bài viết -->
                        <div class="border-detail mt-4 p-3 border rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p class="post-info mb-0">
                                        <span class="me-3">
                                            <i class="far fa-clock"></i>
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                        <span class="me-3">
                                            <i class="far fa-user"></i>
                                            {{ $post->author->name ?? 'Admin' }}
                                        </span>
                                        @if (isset($post->views_count))
                                            <span class="me-3">
                                                <i class="far fa-eye"></i>
                                                {{ $post->views_count }} lượt xem
                                            </span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                    <div class="btn-group">
                                        <button class="btn btn-outline-primary btn-sm me-2" onclick="sharePost()">
                                            <i class="fas fa-share"></i>
                                            <span>Chia sẻ</span>
                                        </button>
                                        <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(route('client.blog.show', $post->slug)) }}"
                                            class="btn btn-outline-secondary btn-sm me-2">
                                            <i class="far fa-envelope"></i>
                                            <span>Email</span>
                                        </a>
                                        <button class="btn btn-outline-info btn-sm" onclick="window.print()">
                                            <i class="fas fa-print"></i>
                                            <span>In</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nút quay lại -->
                        <a href="{{ route('client.blog.index') }}" class="btn btn-outline-secondary mt-4">
                            <i class="fas fa-arrow-left"></i>
                            ← Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sharePost() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $post->title }}',
                    text: '{{ Str::limit(strip_tags($post->content), 100) }}',
                    url: window.location.href,
                });
            } else {
                // Fallback cho trình duyệt không hỗ trợ Web Share API
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Đã sao chép link bài viết!');
                }).catch(() => {
                    // Fallback nếu clipboard API cũng không hoạt động
                    prompt('Sao chép link này:', url);
                });
            }
        }
    </script>
@endsection
