-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 17, 2025 lúc 05:57 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbanhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `tendangnhap` varchar(50) NOT NULL,
  `matkhau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`tendangnhap`, `matkhau`) VALUES
('admin', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chudegopy`
--

CREATE TABLE `chudegopy` (
  `ma_cdgy` int(11) NOT NULL,
  `ten_cdgy` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dondathang`
--

CREATE TABLE `dondathang` (
  `ma_dh` int(11) NOT NULL,
  `dh_ngaylap_dh` datetime NOT NULL,
  `ngaygiao_dh` datetime DEFAULT NULL,
  `noigiao_dh` varchar(255) DEFAULT NULL,
  `trangthaithanhtoan_dh` int(11) NOT NULL,
  `ma_httt` int(11) NOT NULL,
  `tendangnhap` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gopy`
--

CREATE TABLE `gopy` (
  `ma_gy` int(11) NOT NULL,
  `hoten_py` varchar(45) DEFAULT NULL,
  `email_py` varchar(45) DEFAULT NULL,
  `diachi_gy` varchar(100) DEFAULT NULL,
  `dienthoai_gy` varchar(45) DEFAULT NULL,
  `tieude_gy` varchar(255) DEFAULT NULL,
  `noidung_gy` text DEFAULT NULL,
  `ngay_gy` datetime DEFAULT NULL,
  `ma_cdgy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhsanpham`
--

CREATE TABLE `hinhsanpham` (
  `ma_hsp` int(11) NOT NULL,
  `tentaptin_hsp` varchar(255) DEFAULT NULL,
  `ma_sp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhsanpham`
--

INSERT INTO `hinhsanpham` (`ma_hsp`, `tentaptin_hsp`, `ma_sp`) VALUES
(30, 'samsung-s3.webp', 1),
(32, 'ipad4.png', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhthucthanhtoan`
--

CREATE TABLE `hinhthucthanhtoan` (
  `ma_httt` int(11) NOT NULL,
  `ten_httt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhthucthanhtoan`
--

INSERT INTO `hinhthucthanhtoan` (`ma_httt`, `ten_httt`) VALUES
(1, 'Tiền mặt'),
(2, 'Chuyển khoản'),
(3, 'Ship COD');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `tendangnhap` varchar(50) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `ten_kh` varchar(50) NOT NULL,
  `gioitinh_kh` int(11) NOT NULL,
  `diachi_kh` varchar(100) NOT NULL,
  `dienthoai_kh` varchar(50) NOT NULL,
  `email_kh` varchar(50) NOT NULL,
  `ngaysinh_kh` int(11) DEFAULT NULL,
  `thangsinh_kh` int(11) DEFAULT NULL,
  `namsinh_kh` int(11) NOT NULL,
  `cmnd_kh` varchar(50) DEFAULT NULL,
  `makichhoat_kh` varchar(100) DEFAULT NULL,
  `trangthai_kh` int(11) NOT NULL,
  `quantri_kh` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`tendangnhap`, `matkhau`, `ten_kh`, `gioitinh_kh`, `diachi_kh`, `dienthoai_kh`, `email_kh`, `ngaysinh_kh`, `thangsinh_kh`, `namsinh_kh`, `cmnd_kh`, `makichhoat_kh`, `trangthai_kh`, `quantri_kh`) VALUES
('dinhduyvo', '1234@kb', 'Trần Ngọc Bích', 0, 'Hà Nội', '07103.273.34433', 'bichtran@ctu.edu.vn', 2, 2, 1985, '1465879854432', '14200', 1, 0),
('dnpcuong', '123@%^', 'Nguyễn Phú Cường', 0, 'Nam Định', '0915659223', 'phucuong@ctu.edu.vn', 11, 6, 1989, '362209685', '14978', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `ma_km` int(11) NOT NULL,
  `ten_km` varchar(255) DEFAULT NULL,
  `noidung_km` longtext DEFAULT NULL,
  `tungay` date DEFAULT NULL,
  `denngay` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`ma_km`, `ten_km`, `noidung_km`, `tungay`, `denngay`) VALUES
(1, 'KM 2/9', 'Nhân dịp Quốc khánh 2/9, giảm tất cả sản phẩm 5%', '2024-09-01', '2024-09-10'),
(2, 'KM Trung thu', 'Nhân dịp Trung thu tặng voucher 500K tất cả SP', '2024-08-15', '2024-08-30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `ma_lsp` int(11) NOT NULL,
  `ten_lsp` varchar(100) NOT NULL,
  `mota_lsp` varchar(500) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`ma_lsp`, `ten_lsp`, `mota_lsp`) VALUES
(1, 'Máy tính bảng', '0'),
(2, 'Máy tính xách tay', '0'),
(3, 'Điện thoại', '0'),
(4, 'Linh phụ kiện', '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhasanxuat`
--

CREATE TABLE `nhasanxuat` (
  `ma_nxs` int(11) NOT NULL,
  `ten_nxs` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhasanxuat`
--

INSERT INTO `nhasanxuat` (`ma_nxs`, `ten_nxs`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'HTC'),
(4, 'Nokia');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'COD',
  `note` varchar(1000) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0,
  `total_money` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `email`, `phone_number`, `address`, `payment_method`, `note`, `order_date`, `status`, `total_money`) VALUES
(19, 5, 'nguyen', 'ghequaco211@gmail.com', '0978023211', 'Hà nội', 'COD', NULL, '2025-03-16 17:02:52', 0, 41700000),
(20, 4, 'ha linh', 'halinh112@gmail.com', '0978023999', 'Hà nội', 'COD', NULL, '2025-03-16 18:37:22', 0, 20900000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product` varchar(200) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `total_money` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product`, `price`, `num`, `total_money`) VALUES
(5, 19, 1, 'Điện thoại Samsung Galaxy S25 5G 12GB/256G', 20900000, 1, 20900000),
(6, 19, 2, 'Apple Ipad 25 Wifi 256GB', 20800000, 1, 20800000),
(7, 20, 1, 'Điện thoại Samsung Galaxy S25 5G 12GB/256G', 20900000, 1, 20900000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `ma_sp` int(11) NOT NULL,
  `ten_sp` varchar(100) NOT NULL,
  `link_image` varchar(2000) NOT NULL,
  `gia_sp` decimal(12,2) DEFAULT NULL,
  `giacu_sp` decimal(12,2) DEFAULT NULL,
  `mota_ngan_sp` varchar(1000) NOT NULL,
  `mota_chitiet_sp` text DEFAULT NULL,
  `ngaycapnhat_sp` datetime NOT NULL,
  `soluong_sp` int(11) DEFAULT NULL,
  `ma_lsp` int(11) NOT NULL,
  `ma_nsx` int(11) NOT NULL,
  `ma_km` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`ma_sp`, `ten_sp`, `link_image`, `gia_sp`, `giacu_sp`, `mota_ngan_sp`, `mota_chitiet_sp`, `ngaycapnhat_sp`, `soluong_sp`, `ma_lsp`, `ma_nsx`, `ma_km`) VALUES
(1, 'Điện thoại Samsung Galaxy S25 5G 12GB/256G', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/a/tab-s9-fe-5g-doc-quyen.png', 20900000.00, 22900000.00, 'Sản phẩm của Samsung', 'Cấu hình: Qualcomm Snapdragon 8 Elite For Galaxy 8 nhân', '2024-12-01 11:20:30', 50, 3, 2, 0),
(2, 'Apple Ipad 25 Wifi 256GB', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/ipad-air-m3-11-inch_2_.jpg', 20800000.00, 234000000.00, 'CPU  Dual-core Cortex-A9 8GHz', 'Màn hình 9.7 inch,  cảm ứng điện dung đa điểm', '2024-12-12 10:04:45', 100, 1, 1, 0),
(24, 'Samsung', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/g/a/galaxy-a25-xanh-vang.png', 700.00, 300.00, 'Sản phẩm Samsung', 'Màn hình 20.9 inch', '2025-02-17 10:19:26', 400, 1, 1, 1),
(29, 'Samsung', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/d/i/dien-thoai-samsung-galaxy-s25_1__2.png', 100.00, 100.00, '1', '1', '0000-00-00 00:00:00', 1, 1, 1, 1),
(34, 'Samsung', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/d/i/dien-thoai-samsung-galaxy-m55.png', 200.00, 100.00, '1', '1', '0000-00-00 00:00:00', 1, 1, 1, 1),
(35, 'Iphone', 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-15-plus_1__1.png', 500.00, 100.00, '112', '321', '2025-03-10 07:49:57', 122, 1, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham_dondathang`
--

CREATE TABLE `sanpham_dondathang` (
  `ma_sp` int(11) NOT NULL,
  `ma_dh` int(11) NOT NULL,
  `sp_dh_soluong` int(11) NOT NULL,
  `sp_dh_dongia` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `phone_number`, `address`, `password`, `role_id`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'halinh', 'Hà Linh', 'vana@gmail.com', '0123456789', '123 Đường A, Hà Nội', '202cb962ac59075b964b07152d234b70', 1, '2025-02-26 16:34:47', '2025-02-26 16:34:47', 0),
(2, 'tranthib', 'Trần Thị B', 'thib@gmail.com', '0987654321', '456 Đường B, TP. HCM', '34819d7beeabb9260a5c854bc85b3e44', 2, '2025-02-26 16:34:47', '2025-02-26 16:34:47', 0),
(3, 'lemc', 'Lê Mạnh C', 'lemc@gmail.com', '0912345678', '789 Đường C, Đà Nẵng', 'bb77d0d3b3f239fa5db73bdf27b8d29a', 1, '2025-02-26 16:34:47', '2025-02-26 16:34:47', 0),
(4, 'halinh', 'Hà Linh', 'ghequaco211@gmail.com', '0978023211', 'Hà nội', '123456', NULL, NULL, NULL, NULL),
(5, 'anh', 'nguyen', '', '0978023211', 'Hà nội', '1', NULL, NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`tendangnhap`);

--
-- Chỉ mục cho bảng `chudegopy`
--
ALTER TABLE `chudegopy`
  ADD PRIMARY KEY (`ma_cdgy`);

--
-- Chỉ mục cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`ma_dh`),
  ADD KEY `dondathang_khachhang_idx` (`tendangnhap`),
  ADD KEY `dondathang_hinhthucthanhtoan_idx` (`ma_httt`);

--
-- Chỉ mục cho bảng `gopy`
--
ALTER TABLE `gopy`
  ADD PRIMARY KEY (`ma_gy`),
  ADD KEY `gopy_chudegopy_idx` (`ma_cdgy`);

--
-- Chỉ mục cho bảng `hinhsanpham`
--
ALTER TABLE `hinhsanpham`
  ADD PRIMARY KEY (`ma_hsp`),
  ADD KEY `fk_hinhsanpham_sanpham1_idx` (`ma_sp`);

--
-- Chỉ mục cho bảng `hinhthucthanhtoan`
--
ALTER TABLE `hinhthucthanhtoan`
  ADD PRIMARY KEY (`ma_httt`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`tendangnhap`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`ma_km`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`ma_lsp`);

--
-- Chỉ mục cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  ADD PRIMARY KEY (`ma_nxs`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`ma_sp`),
  ADD KEY `sanpham_loaisanpham_idx` (`ma_lsp`),
  ADD KEY `sanpham_nhasanxuat_idx` (`ma_nsx`),
  ADD KEY `sanpham_khuyenmai_idx` (`ma_km`);

--
-- Chỉ mục cho bảng `sanpham_dondathang`
--
ALTER TABLE `sanpham_dondathang`
  ADD PRIMARY KEY (`ma_sp`,`ma_dh`),
  ADD KEY `sanpham_donhang_sanpham_idx` (`ma_sp`),
  ADD KEY `sanpham_donhang_dondathang_idx` (`ma_dh`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  MODIFY `ma_dh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `hinhsanpham`
--
ALTER TABLE `hinhsanpham`
  MODIFY `ma_hsp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `hinhthucthanhtoan`
--
ALTER TABLE `hinhthucthanhtoan`
  MODIFY `ma_httt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `ma_km` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `ma_lsp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  MODIFY `ma_nxs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `ma_sp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  ADD CONSTRAINT `dondathang_hinhthucthanhtoan` FOREIGN KEY (`ma_httt`) REFERENCES `hinhthucthanhtoan` (`ma_httt`),
  ADD CONSTRAINT `dondathang_khachhang` FOREIGN KEY (`tendangnhap`) REFERENCES `khachhang` (`tendangnhap`);

--
-- Các ràng buộc cho bảng `gopy`
--
ALTER TABLE `gopy`
  ADD CONSTRAINT `gopy_chudegopy` FOREIGN KEY (`ma_cdgy`) REFERENCES `chudegopy` (`ma_cdgy`);

--
-- Các ràng buộc cho bảng `hinhsanpham`
--
ALTER TABLE `hinhsanpham`
  ADD CONSTRAINT `fk_hinhsanpham_sanpham1` FOREIGN KEY (`ma_sp`) REFERENCES `sanpham` (`ma_sp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
