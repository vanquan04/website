🛒 Dự án Web Bán Hàng Trực Tuyến – Webbandt
📌 1. Giới Thiệu
Webbandt là một website bán hàng trực tuyến đơn giản và hiệu quả, cung cấp các tính năng cơ bản cho người dùng như:

Xem danh sách sản phẩm theo thương hiệu (iPhone, Samsung, Xiaomi, Oppo, Realme)

Thêm sản phẩm vào giỏ hàng

Tìm kiếm sản phẩm theo tên

Thanh toán đơn hàng

Quản lý đơn hàng đã đặt

Website phù hợp để học tập, nghiên cứu hoặc triển khai cho các shop nhỏ – vừa.

⚙️ 2. Hướng Dẫn Cài Đặt
2.1. Yêu Cầu Hệ Thống
✅ PHP phiên bản 7.4 trở lên

✅ MySQL (phiên bản >= 5.7)

✅ Máy chủ web Apache hoặc Nginx

🛠 Có thể dùng phpMyAdmin để thao tác với cơ sở dữ liệu (không bắt buộc)

2.2. Các Bước Triển Khai
Tải mã nguồn về máy:

bash
Sao chép
Chỉnh sửa
git clone <link-github-repo>
Cấu hình kết nối cơ sở dữ liệu:

Mở các file:

Config/ketnoi.php

ADMIN/connect.php

Thay đổi thông tin như:

php
Sao chép
Chỉnh sửa
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'webbandt';
Import cơ sở dữ liệu:

Mở phpMyAdmin hoặc MySQL CLI

Tạo database webbandt

Import file Database/webbandt.sql:

bash
Sao chép
Chỉnh sửa
mysql -u root -p webbandt < Database/webbandt.sql
Khởi chạy server Apache/Nginx

Truy cập trình duyệt: http://localhost/src/index.php

📂 3. Cấu Trúc Thư Mục Chính
```
📁src/
├── 📁ADMIN/             # Khu vực quản trị (đăng nhập riêng)
├── 📁Config/            # Cấu hình kết nối CSDL
├── 📁Database/          # File SQL để import
├── 📁css/               # Giao diện
├── 📁img/               # Hình ảnh sản phẩm
├── index.php           # Trang chủ
├── cart.php            # Giỏ hàng
├── checkout.php        # Thanh toán
├── product_detail.php  # Chi tiết sản phẩm
├── search.php          # Tìm kiếm
├── login.php / signup.php / logout.php
├── tracuu_donhang.php  # Theo dõi đơn hàng
├── get_cart_count.php  # API đếm số lượng giỏ hàng
└── ...
🔑 4. Lưu Ý Khi Sử Dụng
Phải đảm bảo MySQL và Apache đang hoạt động

Thư mục gốc dự án nên để trong htdocs (nếu dùng XAMPP)

Đảm bảo file .sql được import thành công để tránh lỗi trang trắng

📄 5. File yêu cầu hệ thống (Requiments.txt)
java
Sao chép
Chỉnh sửa
PHP >= 7.4
MySQL >= 5.7
Apache/Nginx
phpMyAdmin (tùy chọn)
📞 6. Liên Hệ Hỗ Trợ
📧 Email: quannguyen04082004@gmail.com

📱 SĐT/Zalo: 0325994526

🎉 Cảm Ơn Bạn Đã Sử Dụng Webbandt!
Chúc bạn triển khai thành công hệ thống bán hàng trực tuyến của riêng mình 🚀

