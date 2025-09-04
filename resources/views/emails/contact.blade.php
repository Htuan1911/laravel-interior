<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Thông báo liên hệ mới</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f4f7f8;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #444;
      line-height: 1.6;
    }
    .email-container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .header {
      background-color: #007BFF;
      color: #fff;
      padding: 20px 30px;
      text-align: center;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
      letter-spacing: 1.2px;
    }
    .content {
      padding: 30px;
    }
    .content p {
      margin: 16px 0;
      font-size: 16px;
    }
    .content .label {
      font-weight: 700;
      color: #333;
    }
    .footer {
      background-color: #f0f0f0;
      color: #999;
      text-align: center;
      padding: 15px 30px;
      font-size: 14px;
    }
    @media screen and (max-width: 620px) {
      .email-container {
        margin: 20px;
      }
      .content {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Liên hệ mới từ website</h1>
    </div>
    <div class="content">
      <p><span class="label">Họ tên:</span> {{ $name }}</p>
      <p><span class="label">Email:</span> {{ $email }}</p>
      <p><span class="label">Nội dung:</span></p>
      <p style="background:#f9f9f9; padding: 15px; border-left: 4px solid #007BFF; white-space: pre-wrap;">{{ $user_message }}</p>
    </div>
    <div class="footer">
      <p>Đây là email tự động, vui lòng không trả lời.</p>
    </div>
  </div>
</body>
</html>
