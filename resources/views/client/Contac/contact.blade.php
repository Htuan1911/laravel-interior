@extends('layouts.master')

@section('content')
<style>
    body {
        background-image: url('https://th.bing.com/th/id/OIP.iue08VMKq4sQ9VJ11JWkLwHaEJ?w=317&h=180&c=7&r=0&o=7&dpr=1.3&pid=1.7&rm=3');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Arial', sans-serif;
    }

    .contact-form {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 40px;
        margin-top: 80px;
        border-radius: 10px;
    }

    .form-control {
        background-color: #fff;
        border: none;
        border-bottom: 2px solid #333;
        border-radius: 0;
        box-shadow: none;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }

    .submit-btn {
        border: 2px solid #000;
        background-color: transparent;
        padding: 10px 30px;
        font-weight: bold;
    }

    .footer-links {
        margin-top: 40px;
        text-align: center;
        color: #000;
        font-weight: 500;
    }

    .footer-links a {
        color: #000;
        text-decoration: none;
        margin: 0 10px;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }

    h2 {
        text-align: center;
        font-weight: bold;
        margin-bottom: 30px;
        letter-spacing: 2px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 contact-form text-center">
            <h2>LIÊN HỆ</h2>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger text-start">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('client.contact.send') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="name" class="form-control" placeholder="Họ và tên" required
                            value="{{ old('name') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email của bạn" required
                        value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <textarea name="message" class="form-control" rows="4" placeholder="Nội dung liên hệ"
                        required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn submit-btn">GỬI</button>
            </form>

            <div class="mt-4">
                <p style="border: 1px solid black; display: inline-block; padding: 10px 20px;">
                    <a href="{{ route('client.blog.index') }}" style="text-decoration: none; color: inherit;">
                        TÌM HIỂU THÊM TRÊN BLOG CỦA CHÚNG TÔI
                    </a>
                </p>
            </div>

            <div class="footer-links mt-3">
                <a href="#">FACEBOOK</a> |
                <a href="#">TWITTER</a> |
                <a href="#">INSTAGRAM</a> |
                <a href="#">PINTEREST</a>
            </div>
        </div>
    </div>
</div>
@endsection