# Laravel-Interior – Website bán đồ nội thất StyleHouse  
> Website thương mại điện tử nhỏ được xây dựng bằng Laravel + Blade, dành cho cửa hàng nội thất “StyleHouse”.

## 🧩 Tính năng nổi bật  
- Trang chủ hiển thị sản phẩm, phân loại nội thất.  
- Chi tiết sản phẩm: gallery ảnh, thông số, đánh giá.  
- Giỏ hàng: thêm/xóa sản phẩm, cập nhật số lượng.  
- Thanh toán theo mô hình mô phỏng (COD hoặc thanh toán online).  
- Đăng nhập/Đăng ký người dùng, phân quyền admin.  
- Bảng quản trị Admin (CRUD sản phẩm, đơn hàng, người dùng).  
- Upload ảnh sản phẩm, sử dụng Laravel File Storage.  
- Responsive design – tương thích màn hình máy tính và di động.  

## 🛠 Công nghệ sử dụng  
- **Backend**: Laravel 10 (PHP 8.x)  
- **Frontend**: Blade Template + TailwindCSS  
- **Database**: MySQL  
- **Authentication**: Laravel Sanctum hoặc Passport (tuỳ cấu hình)  
- **Storage**: Laravel File Storage (ảnh sản phẩm)  
- **Deploy/Hosting**: [nếu có bạn ghi rõ ví dụ: DigitalOcean / Heroku / VPS]  
- **GitHub Repo**: [github.com/Htuan1911/laravel-interior](https://github.com/Htuan1911/laravel-interior)

## ⚙️ Cài đặt & chạy dự án  
```bash
git clone https://github.com/Htuan1911/laravel-interior.git
cd laravel-interior
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm install (nếu dùng frontend build)
php artisan serve

🧑‍💻 Tài khoản demo
Admin: admin@test.com / 123456
User: user@test.com / 123456

👨‍💻 Tác giả
Hoàng Tuấn
Backend Developer – chuyên Laravel & API Restful
📧 Email: tuan178804@gmail.com
🌐 GitHub: github.com/Htuan1911
