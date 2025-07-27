<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }
    body {
      background-color: #2a263a;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      display: flex;
      width: 900px;
      height: 550px;
      background-color: #2c273f;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    }
    .left {
      flex: 1;
      position: relative;
      overflow: hidden;
    }
    .slideshow {
      position: absolute;
      width: 100%;
      height: 100%;
    }
    .slide {
      position: absolute;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }
    .slide.active {
      opacity: 1;
    }
    .slide-caption-box {
      position: absolute;
      bottom: 30px;
      left: 30px;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 15px;
    }
    .slide-caption {
      font-size: 1.1rem;
      color: #fff;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
      font-weight: 500;
    }
    .slide-indicators {
      display: flex;
      gap: 10px;
    }
    .indicator {
      width: 20px;
      height: 4px;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 2px;
      transition: all 0.3s ease;
    }
    .indicator.active {
      background: #fff;
    }
    .right {
      flex: 1;
      padding: 50px 40px;
      background-color: #2c273f;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: #fff;
    }
    .form-title {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #fff;
    }
    .form-subtext {
      margin-bottom: 25px;
      color: #aaa;
      font-size: 0.9rem;
    }
    input[type="email"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-top: 12px;
      background-color: #1e1b2e;
      border: 1px solid #555;
      border-radius: 6px;
      color: #fff;
    }
    input[type="checkbox"] {
      width: auto;
      accent-color: #9a7dff;
    }
    .remember-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 15px;
      font-size: 0.85rem;
      color: #aaa;
    }
    .remember-row label {
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
    }
    .remember-row a {
      color: #9a7dff;
      text-decoration: none;
    }
    .btn {
      margin-top: 25px;
      padding: 14px;
      background-color: #9a7dff;
      border: none;
      border-radius: 6px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
    }
    .or {
      text-align: center;
      margin: 25px 0;
      opacity: 0.6;
      font-size: 0.85rem;
      color: #bbb;
    }
    .social-buttons {
      display: flex;
      justify-content: space-between;
      gap: 15px;
    }
    .social-buttons button {
      flex: 1;
      padding: 12px;
      border: 1px solid #555;
      background-color: transparent;
      border-radius: 6px;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 0.9rem;
    }
    .social-buttons button img {
      width: 18px;
      height: 18px;
    }
    a {
      color: #9a7dff;
      text-decoration: none;
    }
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        width: 100%;
        height: auto;
        border-radius: 0;
      }
      .left, .right {
        width: 100%;
        height: 50%;
      }
      .right {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="slideshow">
        <div class="slide active" style="background-image: url('img/home/home1-banner1.jpg');"></div>
        <div class="slide" style="background-image: url('img/home/home1-banner2.jpg');"></div>
        <div class="slide" style="background-image: url('img/home/home1-banner3.jpg');"></div>
      </div>
      <div class="slide-caption-box">
        <div class="slide-caption" id="caption">Welcome back. Let’s capture again.</div>
        <div class="slide-indicators">
          <div class="indicator active"></div>
          <div class="indicator"></div>
          <div class="indicator"></div>
        </div>
      </div>
    </div>

    <div class="right">
      {{-- Hiển thị trạng thái session (nếu có) --}}
      @if (session('status'))
        <div style="margin-bottom: 16px; color: #f88;">
          {{ session('status') }}
        </div>
      @endif

      <div class="form-title">Sign in to your account</div>
      <div class="form-subtext">
        Don't have an account? <a href="{{ route('register') }}">Sign up</a>
      </div>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
          <label for="email" style="font-weight: 500;">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
          @error('email')
            <div style="color: #f88; margin-top: 6px;">{{ $message }}</div>
          @enderror
        </div>

        <div style="margin-top: 20px;">
          <label for="password" style="font-weight: 500;">Password</label>
          <input id="password" type="password" name="password" required autocomplete="current-password" />
          @error('password')
            <div style="color: #f88; margin-top: 6px;">{{ $message }}</div>
          @enderror
        </div>

        <div class="remember-row" style="margin-top: 15px;">
          <label for="remember_me">
            <input id="remember_me" type="checkbox" name="remember" />
            Remember me
          </label>
          @if (Route::has('password.request'))
          <a href="{{ route('password.otp.email.form') }}">Forgot password?</a>
          @endif
        </div>

        <button type="submit" class="btn">Sign in</button>
      </form>

      <div class="or">Or sign in with</div>

      <div class="social-buttons">
        <button><img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google logo" />Google</button>
        <button><img src="https://img.icons8.com/ios-filled/50/ffffff/mac-os.png" alt="Apple logo" />Apple</button>
      </div>
    </div>
  </div>

  <script>
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    const caption = document.getElementById('caption');

    const captions = [
      "Welcome back. Let’s capture again.",
      "Reconnect with your favorite moments.",
      "Continue your visual journey today."
    ];

    let currentSlide = 0;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
        indicators[i].classList.toggle('active', i === index);
      });
      caption.textContent = captions[index];
    }

    setInterval(() => {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }, 4000);
  </script>
</body>
</html>
