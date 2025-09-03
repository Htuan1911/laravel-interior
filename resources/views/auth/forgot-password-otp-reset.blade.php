<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đặt lại mật khẩu</title>
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
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
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
      text-align: center;
    }

    .form-subtext {
      text-align: center;
      color: #aaa;
      font-size: 0.9rem;
      margin-bottom: 25px;
    }

    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      background-color: #1e1b2e;
      border: 1px solid #555;
      border-radius: 6px;
      color: #fff;
    }

    .btn {
      margin-top: 30px;
      padding: 14px;
      background-color: #9a7dff;
      border: none;
      border-radius: 6px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
    }

    .error-message {
      color: #ff9999;
      margin-top: 10px;
      font-size: 0.9rem;
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
    <!-- Slide trái -->
    <div class="left">
      <div class="slideshow">
        <div class="slide active" style="background-image: url('img/home/home1-banner1.jpg');"></div>
        <div class="slide" style="background-image: url('img/home/home1-banner2.jpg');"></div>
        <div class="slide" style="background-image: url('img/home/home1-banner3.jpg');"></div>
      </div>
      <div class="slide-caption-box">
        <div class="slide-caption" id="caption">Đặt lại mật khẩu mới cho tài khoản của bạn.</div>
        <div class="slide-indicators">
          <div class="indicator active"></div>
          <div class="indicator"></div>
          <div class="indicator"></div>
        </div>
      </div>
    </div>

    <!-- Form phải -->
    <div class="right">
      <div class="form-title">Đặt lại mật khẩu</div>
      <div class="form-subtext">Vui lòng nhập mật khẩu mới của bạn bên dưới.</div>

      <form method="POST" action="{{ route('password.otp.reset') }}">
        @csrf

        <label for="password">Mật khẩu mới</label>
        <input type="password" id="password" name="password" required />

        <label for="password_confirmation" style="margin-top: 15px;">Xác nhận mật khẩu</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />

        @if ($errors->any())
          <div class="error-message">
            @foreach ($errors->all() as $error)
              {{ $error }}<br>
            @endforeach
          </div>
        @endif

        <button type="submit" class="btn">Đặt lại mật khẩu</button>
      </form>
    </div>
  </div>

  <script>
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    const caption = document.getElementById('caption');

    const captions = [
      "Đặt lại mật khẩu mới cho tài khoản của bạn.",
      "Tạo mật khẩu mạnh và an toàn hơn.",
      "Không chia sẻ mật khẩu với bất kỳ ai."
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
</htm
