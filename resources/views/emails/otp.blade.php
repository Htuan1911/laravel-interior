<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Xác minh tài khoản</title>
<style>
  body {
    background-color: #f4f6f8;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    -webkit-font-smoothing: antialiased;
  }
  .container {
    max-width: 480px;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 8px;
    padding: 30px 40px;
    box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
    color: #333333;
  }
  h2 {
    color: #1e88e5;
    margin-bottom: 24px;
    font-weight: 700;
    font-size: 24px;
    text-align: center;
  }
  p {
    font-size: 16px;
    line-height: 1.5;
    margin: 14px 0;
  }
  .otp-code {
    display: block;
    margin: 20px auto;
    background: #e3f2fd;
    border: 2px dashed #1e88e5;
    border-radius: 8px;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: 8px;
    color: #1e88e5;
    width: fit-content;
    padding: 10px 28px;
    text-align: center;
    user-select: all;
  }
  .footer {
    font-size: 14px;
    color: #777777;
    text-align: center;
    margin-top: 36px;
  }
  @media (max-width: 520px) {
    .container {
      padding: 20px 16px;
      margin: 20px 12px;
    }
    .otp-code {
      font-size: 26px;
      letter-spacing: 6px;
      padding: 8px 20px;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Xác minh tài khoản</h2>
    <p>Chào bạn,</p>
    <p>Mã OTP của bạn là:</p>
    <span class="otp-code">{{ $otp }}</span>
    <p>Mã này có hiệu lực trong <strong>10 phút</strong>.</p>
    <p><strong>Vui lòng không chia sẻ mã này với bất kỳ ai.</strong></p>
    <div class="footer">
      <p>Nếu bạn không yêu cầu mã này, vui lòng bỏ qua email này.</p>
      <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    </div>
  </div>
</body>
</html>
