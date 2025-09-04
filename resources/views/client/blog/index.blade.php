@extends('layouts.blog')

@section('contentblog')
    <div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper">
                <div id="main">
                    <div class="page-home">
                        <div class="container">
                            <div class="content">
                                <div class="row">
                                    <div class="col main-blogs">
                                        <h2 class="text-center col">Recent Posts</h2>

                                        @forelse ($posts as $post)
                                            <div class="row mb-4 align-items-center">
                                                <div class="col-md-4">
                                                    <a href="{{ route('client.blog.show', $post->slug) }}">
                                                        <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                                                            class="img-fluid rounded">
                                                    </a>
                                                </div>
                                                <div class="col-md-8">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('client.blog.show', $post->slug) }}">
                                                            {{ $post->title }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-1">
                                                        <small>{{ $post->created_at->diffForHumans() }} |
                                                            {{ $post->comments_count ?? 0 }} Comments |
                                                            {{ $post->author->name ?? 'ADMIN' }}</small>
                                                    </p>
                                                    <p>
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                                                        <a href="{{ route('client.blog.show', $post->slug) }}"
                                                            class="text-primary">Xem thêm</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <hr>
                                        @empty
                                            <p class="text-center">Chưa có bài viết nào.</p>
                                        @endforelse

                                        <!-- Pagination -->
                                        {{-- <div class="d-flex justify-content-center">
                                            {{ $posts->links() }}
                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
