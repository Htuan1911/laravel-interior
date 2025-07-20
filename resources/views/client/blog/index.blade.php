@extends('layouts.blog')

@section('contentblog')
<div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper">
                <div id="main">
                    <div class="page-home">
                        <!-- breadcrumb -->
                        
                        <div class="container">
                            <div class="content">
                                <div class="row">
                                    <div class="col main-blogs">
                                        <h2 class="text-center col">Recent Posts</h2>
                                        <div class="row">
                                             <div class="col-md-6 col-xs-12">
                                                <div class="hover-after">
                                                    <a href="blog-detail.html">
                                                        <img src="img/blog/4.jpg" alt="img">
                                                    </a>
                                                </div>
                                                <div class="late-item">
                                                    @forelse ($posts as $post)
                                                    <div class="col-md-6 col-xs-12">
                                                        <div class="hover-after">
                                                            <a href="{{ route('client.blog.show', $post->slug) }}">
                                                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                                                            </a>
                                                        </div>
                                                        <div class="late-item">
                                                            <p class="content-title">
                                                                <a href="{{ route('client.blog.show', $post->slug) }}">{{ $post->title }}</a>
                                                            </p>
                                                            <p class="post-info">
                                                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                                                <span>{{ $post->comments_count ?? 0 }} Comments</span>
                                                                <span>{{ $post->author->name ?? 'ADMIN' }}</span>
                                                            </p>
                                                            <p class="description">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}
                                                                <span class="view-more">
                                                                    <a href="{{ route('client.blog.show', $post->slug) }}">view more</a>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @empty
                                                <div class="col-12">
                                                        <p class="text-center">Chưa có bài viết nào.</p>
                                            </div>
                                                    @endforelse

                                                    <!-- Pagination -->
                                                    {{ $posts->links() }}       
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="page-list col">
                                            <ul class="justify-content-center d-flex">
                                                <li>
                                                    <a rel="prev" href="#" class="previous disabled js-search-link">
                                                        Previous
                                                    </a>
                                                </li>
                                                <li class="current active">
                                                    <a rel="nofollow" href="#" class="disabled js-search-link">
                                                        1
                                                    </a>
                                                </li>
                                                <li>
                                                    <a rel="nofollow" href="#" class="disabled js-search-link">
                                                        2
                                                    </a>
                                                </li>
                                                <li>
                                                    <a rel="next" href="#" class="next disabled js-search-link">
                                                        Next
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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
