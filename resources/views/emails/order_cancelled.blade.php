<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo hủy đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
            background: #fff;
        }
        .order-info {
            background-color: #fdf2f2;
            padding: 10px;
            margin: 15px 0;
            border-left: 4px solid #dc3545;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #888;
            background-color: #f9f9f9;
        }
        a {
            color: #dc3545;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        strong {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            🚫 Thông báo hủy đơn hàng
        </div>

        <div class="content">
            <p>Xin chào <strong>{{ $order->user->name ?? 'Quý khách' }}</strong>,</p>

            <p>Chúng tôi rất tiếc phải thông báo rằng đơn hàng <strong>#{{ $order->id }}</strong> của bạn đã được <strong>hủy</strong>.</p>

            <div class="order-info">
                <p><strong>Lý do hủy:</strong> {{ $cancelReason }}</p>
            </div>

            <p>Chúng tôi luôn mong muốn mang đến trải nghiệm mua sắm tốt nhất cho bạn.  
               Nếu có bất kỳ thắc mắc hoặc cần hỗ trợ đặt lại đơn hàng, vui lòng liên hệ với chúng tôi qua email 
               <a href="mailto:support@noithat.vn">support@noithat.vn</a>  
               hoặc gọi hotline <strong>0981 234 567</strong>.
            </p>

            <p>Rất mong được phục vụ bạn trong những lần mua sắm tiếp theo ❤️</p>

            <p>Trân trọng,<br>
            <strong>{{ config('app.name') }}</strong></p>
        </div>

        <div class="footer">
            Đây là email tự động, vui lòng không trả lời trực tiếp.
        </div>
    </div>
</body>
</html>
