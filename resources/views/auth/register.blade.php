<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <style>
    * {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #18162b;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      display: flex;
      background-color: #241f3a;
      border-radius: 16px;
      overflow: hidden;
      width: 960px;
      max-width: 100%;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
    }

    .slideshow {
      width: 45%;
      position: relative;
    }

    .slide {
      position: absolute;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      opacity: 0;
      transition: opacity 0.8s ease-in-out;
    }

    .slide.active {
      opacity: 1;
      position: relative;
    }

    .slide-caption {
      position: absolute;
      bottom: 20px;
      left: 20px;
      color: #fff;
      font-weight: 500;
      font-size: 1rem;
      text-shadow: 0 0 8px rgba(0,0,0,0.6);
    }

    .dots {
      position: absolute;
      bottom: 10px;
      left: 20px;
      display: flex;
      gap: 8px;
    }

    .dot {
      width: 20px;
      height: 4px;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 2px;
      cursor: pointer;
    }

    .dot.active {
      background-color: #fff;
    }

    .form-wrapper {
      width: 55%;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background-color: #241f3a;
    }

    h2 {
      font-size: 1.8rem;
      margin-bottom: 10px;
      color: #fff;
    }

    .form-wrapper p {
      font-size: 0.9rem;
      margin-bottom: 25px;
      color: #aaa;
    }

    .form-wrapper a {
      color: #9577ff;
      text-decoration: none;
    }

    .form-wrapper a:hover {
      text-decoration: underline;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .form-row {
      display: flex;
      gap: 15px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      background-color: #1b1a2f;
      border: 1px solid #3c3a5a;
      padding: 12px 16px;
      border-radius: 8px;
      color: #eee;
      font-size: 0.95rem;
      width: 100%;
    }

    input::placeholder {
      color: #777a91;
    }

    .error {
      font-size: 0.8rem;
      color: #ff8080;
      margin-top: -10px;
      margin-bottom: 8px;
    }

    button {
      background-color: #9577ff;
      border: none;
      padding: 14px;
      color: white;
      border-radius: 8px;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #7d5fff;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .slideshow, .form-wrapper {
        width: 100%;
        height: 300px;
      }

      .form-wrapper {
        padding: 30px 20px;
      }

      .form-row {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <!-- Slideshow -->
  <div class="slideshow">
    <div class="slide active" style="background-image: url('img/home/home1-banner1.jpg');">
      <div class="slide-caption">Capturing Moments, Creating Memories</div>
    </div>
    <div class="slide" style="background-image: url('img/home/home1-banner2.jpg');">
      <div class="slide-caption">Experience Nature's Beauty</div>
    </div>
    <div class="slide" style="background-image: url('img/home/home1-banner3.jpg');">
      <div class="slide-caption">Adventure Awaits</div>
    </div>
    <div class="dots">
      <div class="dot active" data-index="0"></div>
      <div class="dot" data-index="1"></div>
      <div class="dot" data-index="2"></div>
    </div>
  </div>

  <!-- Form -->
  <div class="form-wrapper">
    <h2>Create an account</h2>
    <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="form-row">
        <div>
          <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus autocomplete="name" />
          @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div>
          <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="username" />
          @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>
      </div>

      <div>
        <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}" required autocomplete="tel" />
        @error('phone') <div class="error">{{ $message }}</div> @enderror
      </div>

      <div>
        <input type="password" name="password" placeholder="Enter your password" required autocomplete="new-password" />
        @error('password') <div class="error">{{ $message }}</div> @enderror
      </div>

      <div>
        <input type="password" name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password" />
        @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror
      </div>

      <button type="submit">Create account</button>
    </form>
  </div>
</div>

<script>
  const slides = document.querySelectorAll('.slide');
  const dots = document.querySelectorAll('.dot');
  let current = 0;

  function showSlide(index) {
    slides.forEach((s, i) => {
      s.classList.toggle('active', i === index);
      dots[i].classList.toggle('active', i === index);
    });
    current = index;
  }

  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      showSlide(parseInt(dot.dataset.index));
    });
  });

  setInterval(() => {
    let next = (current + 1) % slides.length;
    showSlide(next);
  }, 5000);
</script>
</body>
</html>
