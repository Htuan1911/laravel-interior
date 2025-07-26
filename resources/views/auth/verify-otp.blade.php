<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enter OTP</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        /* giữ nguyên style bạn gửi */
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

        #otp-inputs {
            display: flex;
            gap: 10px;
            margin: 25px 0;
        }

        .otp-digit {
            width: 60px;
            /* tăng từ 45px lên 60px */
            height: 60px;
            /* tăng từ 50px lên 60px */
            text-align: center;
            font-size: 1.5rem;
            /* tăng font cho to hơn */
            border-radius: 6px;
            border: 1px solid #555;
            background-color: #1e1b2e;
            color: #fff;
        }

        .otp-digit:focus {
            outline: none;
            border-color: #9a7dff;
        }

        .btn {
            margin-top: 10px;
            padding: 14px;
            background-color: #9a7dff;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .resend {
            margin-top: 20px;
            text-align: center;
            color: #aaa;
            font-size: 0.9rem;
        }

        .resend a {
            color: #9a7dff;
            text-decoration: none;
            margin-left: 4px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 100%;
                height: auto;
                border-radius: 0;
            }

            .left,
            .right {
                width: 100%;
                height: 50%;
            }

            .right {
                padding: 30px 20px;
            }

            #otp-inputs {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="slideshow">
                <div class="slide active" style="background-image: url('img/home/home1-banner1.jpg');">
                </div>
                <div class="slide" style="background-image: url('img/home/home1-banner2.jpg');">
                </div>
                <div class="slide" style="background-image: url('img/home/home1-banner3.jpg');">
                </div>
            </div>
            <div class="slide-caption-box">
                <div class="slide-caption" id="caption">Enter your verification code below.</div>
                <div class="slide-indicators">
                    <div class="indicator active"></div>
                    <div class="indicator"></div>
                    <div class="indicator"></div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="form-title">Enter the verification code</div>
            <div class="form-subtext">
                We've sent a 6-digit code to your email. Please check and enter it below.
            </div>

            <!-- Form gửi về route Laravel verify.otp -->
            <form method="POST" action="{{ route('verify.otp') }}" id="otp-form">
                @csrf
                <input type="hidden" id="otp" name="otp" />

                <div id="otp-inputs">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit"
                        autocomplete="one-time-code" />
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit"
                        autocomplete="one-time-code" />
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit"
                        autocomplete="one-time-code" />
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit"
                        autocomplete="one-time-code" />
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit"
                        autocomplete="one-time-code" />
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit"
                        autocomplete="one-time-code" />
                </div>
                <!-- Hiển thị lỗi OTP nếu có -->
                @if ($errors->has('otp'))
                <div class="error-message" style="color: #ff6b6b; margin-top: 10px; font-weight: 600;">
                    {{ $errors->first('otp') }}
                </div>
                @endif

                <button type="submit" class="btn">Verify</button>
            </form>


        </div>
    </div>

    <script>
        // Slideshow logic (giữ nguyên)
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    const caption = document.getElementById('caption');

    const captions = [
      "Enter your verification code below.",
      "Make sure the code is correct and valid.",
      "Secure your login with verification."
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

    // OTP input logic (theo backend Laravel style)
    document.addEventListener('DOMContentLoaded', () => {
      const otpInputs = document.querySelectorAll('#otp-inputs .otp-digit');
      const hiddenOtpInput = document.getElementById('otp');

      otpInputs.forEach((input, index) => {
        input.addEventListener('input', e => {
          // Chỉ cho phép số
          e.target.value = e.target.value.replace(/[^0-9]/g, '');

          // Tự động focus ô tiếp theo khi nhập đủ 1 ký tự
          if (e.target.value.length === 1 && index < otpInputs.length - 1) {
            otpInputs[index + 1].focus();
          }

          updateHiddenOtp();
        });

        input.addEventListener('keydown', e => {
          if (e.key === 'Backspace' && !e.target.value && index > 0) {
            otpInputs[index - 1].focus();
          }
        });

        // Paste vào ô đầu tiên
        input.addEventListener('paste', e => {
          e.preventDefault();
          const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
          if (/^\d{6}$/.test(pasteData)) {
            otpInputs.forEach((input, i) => {
              input.value = pasteData[i];
            });
            updateHiddenOtp();
            otpInputs[otpInputs.length -1].focus();
          }
        });
      });

      function updateHiddenOtp() {
        const otpValue = Array.from(otpInputs).map(i => i.value).join('');
        hiddenOtpInput.value = otpValue;
      }

      // Khi submit form kiểm tra đủ 6 số
      document.getElementById('otp-form').addEventListener('submit', e => {
        updateHiddenOtp();
        if (hiddenOtpInput.value.length !== 6) {
          e.preventDefault();
          alert('Vui lòng nhập đủ 6 số mã OTP.');
        }
      });
    });

    // Resend OTP (giữ nguyên)
    const resendLink = document.getElementById('resend-link');
    resendLink.addEventListener('click', (e) => {
      e.preventDefault();
      alert('Mã OTP đã được gửi lại!');
      // TODO: Gọi API backend gửi lại OTP
    });
    </script>
</body>

</html>