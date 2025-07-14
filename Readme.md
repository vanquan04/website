# Dự án Quản lý Bán hàng - Webbandt

## 1. Giới thiệu
Dự án này là một website bán hàng trực tuyến, hỗ trợ quản lý giỏ hàng, tìm kiếm sản phẩm và xử lý thanh toán.

## 2. Cài đặt
### 2.1. Yêu cầu hệ thống
- PHP 7.4 trở lên
- MySQL
- Apache/Nginx

### 2.2. Cài đặt
1. Clone hoặc tải source code về máy:
   ```sh
   git clone <repo-url>
   ```
2. Cấu hình cơ sở dữ liệu trong `Config/ketnoi.php` và `ADMIN/connect.php`
3. Import database vào MySQL:
   - Mở MySQL hoặc phpMyAdmin
   - Tạo một database mới tên `webbandt`
   - Import file `Database/webbandt.sql`
4. Khởi chạy server Apache/Nginx và truy cập trang web

## 3. Cấu trúc thư mục `📁src`
```
📁src/
│── 📁ADMIN/
│   │── connect.php
│   └── ...
│── 📁Config/
│   │── ketnoi.php
│   └── ...
│── 📁css/
│── 📁Database/
│   │── webbandt.sql
│── 📁img/
│── add_to_cart.php
│── cart.php
│── checkout.php
│── dsiphone.php
│── dsoppo.php
│── dsrealme.php
│── dssamsung.php
│── dsxiaomi.php
│── get_cart_count.php
│── index.php
│── iphone.php
│── login.php
│── logout.php
│── oppo.php
│── product_detail.php
│── realme.php
│── samsung.php
│── search.php
│── signup.php
│── tracuu_donhang.php
│── xiaomi.php
│── README.md
│── Requiments.txt
```

## 4. Lưu ý khi kết nối CSDL
- Cần chỉnh sửa file `Config/ketnoi.php` và `ADMIN/connect.php` trước khi chạy.
- Kiểm tra tên CSDL, username và password trước khi kết nối.

## 5. Hướng dẫn import Database
1. Mở MySQL hoặc phpMyAdmin
2. Tạo database mới tên `webbandt`
3. Chạy lệnh sau để import database:
   ```sh
   mysql -u root -p webbandt < Database/webbandt.sql
   ```
4. Kiểm tra lại dữ liệu đã import thành công

## 6. File Requiments.txt
```
PHP >= 7.4
MySQL >= 5.7
Apache/Nginx
phpMyAdmin (tùy chọn)
```

## 7. Liên hệ
- Email: quannguyen04082004@gmail.com
- SDT: 0325994526

**Chúc bạn thành công!** 🚀

