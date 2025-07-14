<?php
include('./Config/ketnoi.php');
session_start();
if (!isset($_SESSION['user']) && !isset($_GET['id'])) {
    
    // Redirect to login page with return URL
    $return_url = urlencode('tracuudonhang.php');
    header("Location: login.php?return_url=$return_url");
    exit;
}

$order = null;
$order_details = null;
$error_message = '';
$success = false;

// Kiểm tra nếu form được gửi đi
if (isset($_POST['search_order'])) {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $order_id = isset($_POST['order_id']) ? trim(mysqli_real_escape_string($conn, $_POST['order_id'])) : '';
    
    // Tạo câu truy vấn dựa vào thông tin nhập vào
    $query = "SELECT * FROM orders WHERE 1=1";
    
    if (!empty($email)) {
        $query .= " AND email LIKE '%$email%'";
    }
    
    if (!empty($phone)) {
        $query .= " AND phone_number LIKE '%$phone%'";
    }
    
    if (!empty($order_id)) {
        $query .= " AND id = '$order_id'";
    }
    
    // Thực hiện truy vấn
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $success = true;
        $orders = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    } else {
        $error_message = 'Không tìm thấy đơn hàng với thông tin đã nhập.';
    }
}

// Hiển thị chi tiết đơn hàng nếu có order_id
if (isset($_GET['id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Lấy thông tin đơn hàng
    $query_order = "SELECT * FROM orders WHERE id = '$order_id'";
    $result_order = mysqli_query($conn, $query_order);
    
    if ($result_order && mysqli_num_rows($result_order) > 0) {
        $order = mysqli_fetch_assoc($result_order);
        
        // Lấy chi tiết đơn hàng
        $query_details = "SELECT * FROM order_details WHERE order_id = '$order_id'";
        $result_details = mysqli_query($conn, $query_details);
        
        if ($result_details && mysqli_num_rows($result_details) > 0) {
            $order_details = [];
            while ($row = mysqli_fetch_assoc($result_details)) {
                $order_details[] = $row;
            }
        }
    } else {
        $error_message = 'Không tìm thấy chi tiết đơn hàng.';
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng - realphoneA</title>
    <link rel="stylesheet" href="css/index.css">
    <style>
    .search-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .search-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #d70018;
    }

    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    .search-btn {
        background-color: #d70018;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
        margin-top: 25px;
    }

    .result-container {
        margin-top: 30px;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-table th,
    .order-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .order-table th {
        background-color: #f5f5f5;
    }

    .order-detail-link {
        color: #d70018;
        text-decoration: none;
        font-weight: bold;
    }

    .order-detail-link:hover {
        text-decoration: underline;
    }

    .message {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 3px;
    }

    .error {
        background-color: #ffe6e6;
        border: 1px solid #ff8080;
        color: #d70018;
    }

    .order-details {
        margin-top: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        padding-bottom: 15px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .order-info {
        line-height: 1.6;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .detail-table th,
    .detail-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .detail-table th {
        background-color: #f5f5f5;
    }

    .total-row {
        font-weight: bold;
        background-color: #f5f5f5;
    }
    </style>
</head>

<body>
    <!-- Top Banner -->
    <div class="top-banner">
        🔴 Quà 'SHE' MÊ - Sale cực đỉnh. Chọn quà ngay!
    </div>

    <!-- Sub Header -->
    <div class="sub-header">
        <div class="sub-header-item">
            <img src="https://cdn-icons-png.flaticon.com/128/831/831378.png" alt="App Icon">
            Tải App Smember - Tích điểm & nhận ưu đãi
        </div>
        <div class="sub-header-item">
            <img src="https://cdn-icons-png.flaticon.com/128/5991/5991056.png" alt="Used Product Icon">
            Thu cũ Giá ngon - Lên đời tiết kiệm
        </div>
        <div class="sub-header-item">
            <img src="https://cdn-icons-png.flaticon.com/128/16459/16459555.png" alt="Authentic Icon">
            Sản phẩm Chính hãng - Xuất VAT đầy đủ
        </div>
    </div>

    <!-- Main Header -->
    <div class="header">
        <div class="logo"><a href="index.php" style="color: white; text-decoration: none;">realphoneA</a></div>
        <button class="menu-button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            Danh mục
        </button>

        <div class="search-box">
            <form action="search.php" method="GET">
                <input type="text" name="keyword" placeholder="Bạn cần tìm gì?" required>
                <button type="submit"
                    style="display: flex; background-color: red; color: #fff;padding: 0 10px; border: none; border-radius: 5px; cursor: pointer;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>

        <div class="header-icons">
            <div class="icon-button">
                <a href="tracuudonhang.php" style="text-decoration: none; color: white;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                        <polygon points="12 15 17 21 7 21 12 15"></polygon>
                    </svg>
                    <br>Tra cứu đơn hàng
                </a>
            </div>
            <div class="icon-button">
                <a href="cart.php" style="text-decoration: none; color: white;">

                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <br>Giỏ hàng
                    <?php 
                    $total_items = 0;
                    if(isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $total_items += $item['quantity'];
                        }
                    }
                    ?>
                    <span class="cart-counter"
                        style="position: absolute; top: -5px; right: -5px; background-color: yellow; color: black; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px;"><?php echo $total_items; ?></span>
                </a>
            </div>
            <div class="icon-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <?php
                if(isset($_SESSION['user'])) {
                    echo '<span>' . $_SESSION['user']['fullname'] . '</span>';
                    echo '<a href="logout.php" style="display:block; color:white; font-size:12px; text-decoration:none;">Đăng xuất</a>';
                } else {
                    echo '<a href="login.php" style="display:block; color:white; font-size:12px; text-decoration:none;">Đăng nhập</a>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-item">
                <span>Điện thoại, Tablet</span>
                <span>›</span>
                <div class="dropdown footer-section">
                    <div class="dropdown-item"><a href="dsiphone.php">iPhone</a></div>
                    <div class="dropdown-item"><a href="dssamsung.php">Samsung</a></div>
                    <div class="dropdown-item"><a href="dsxiaomi.php">Xiaomi</a></div>
                    <div class="dropdown-item"><a href="dsoppo.php">OPPO</a></div>
                    <div class="dropdown-item"><a href="dsrealme.php">realme</a></div>
                </div>
            </div>
            <div class="sidebar-item">
                <span>Laptop</span>
                <span>›</span>
                <div class="dropdown footer-section">
                    <div class="dropdown-item"><a href="#">MacBook</a></div>
                    <div class="dropdown-item"><a href="#">Asus</a></div>
                    <div class="dropdown-item"><a href="#">Dell</a></div>
                    <div class="dropdown-item"><a href="#">HP</a></div>
                    <div class="dropdown-item"><a href="#">Lenovo</a></div>
                </div>
            </div>
            <div class="sidebar-item">
                <span>Âm thanh</span>
                <span>›</span>
                <div class="dropdown footer-section">
                    <div class="dropdown-item"><a href="#">Tai nghe</a></div>
                    <div class="dropdown-item"><a href="#">Loa</a></div>
                    <div class="dropdown-item"><a href="#">Tai nghe không dây</a></div>
                </div>
            </div>
        </div>
        <!-- Search Container -->
        <div class="search-container">
            <h1 class="search-title">Tra cứu đơn hàng</h1>

            <?php if (!isset($_GET['id'])): ?>
            <!-- Search Form -->
            <form method="post" action="tracuudonhang.php" class="search-form">
                <div class="form-group">
                    <label for="email">Email đặt hàng:</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email bạn đã dùng khi đặt hàng">
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại bạn đã dùng khi đặt hàng">
                </div>

                <div class="form-group">
                    <button type="submit" name="search_order" class="search-btn">Tra cứu</button>
                </div>
            </form>

            <?php if (isset($_POST['search_order'])): ?>
            <?php if ($error_message): ?>
            <div class="message error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="result-container">
                <h2>Kết quả tìm kiếm:</h2>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Họ tên</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                            <td><?php echo $order['fullname']; ?></td>
                            <td><?php echo number_format($order['total_money'], 0, ',', '.'); ?>đ</td>
                            <td>
                                <?php 
                                            switch ($order['status']) {
                                                case 'pending':
                                                    echo 'Chờ xác nhận';
                                                    break;
                                                case 'processing':
                                                    echo 'Đang xử lý';
                                                    break;
                                                case 'shipped':
                                                    echo 'Đang giao hàng';
                                                    break;
                                                case 'delivered':
                                                    echo 'Đã giao hàng';
                                                    break;
                                                case 'cancelled':
                                                    echo 'Đã hủy';
                                                    break;
                                                default:
                                                    echo $order['status'];
                                            }
                                            ?>
                            </td>
                            <td><a href="tracuudonhang.php?id=<?php echo $order['id']; ?>" class="order-detail-link">Xem
                                    chi tiết</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            <?php endif; ?>
            <?php else: ?>
            <!-- Order Detail View -->
            <?php if ($error_message): ?>
            <div class="message error"><?php echo $error_message; ?></div>
            <?php elseif ($order): ?>
            <div class="order-details">
                <div class="order-header">
                    <h2>Chi tiết đơn hàng #<?php echo $order['id']; ?></h2>
                    <div class="order-status">
                        Trạng thái:
                        <strong>
                            <?php 
                                switch ($order['status']) {
                                    case 'pending':
                                        echo 'Chờ xác nhận';
                                        break;
                                    case 'processing':
                                        echo 'Đang xử lý';
                                        break;
                                    case 'shipped':
                                        echo 'Đang giao hàng';
                                        break;
                                    case 'delivered':
                                        echo 'Đã giao hàng';
                                        break;
                                    case 'cancelled':
                                        echo 'Đã hủy';
                                        break;
                                    default:
                                        echo $order['status'];
                                }
                                ?>
                        </strong>
                    </div>
                </div>

                <div class="order-info">
                    <p><strong>Ngày đặt hàng:</strong> <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?>
                    </p>
                    <p><strong>Họ tên:</strong> <?php echo $order['fullname']; ?></p>
                    <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo $order['phone_number']; ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo $order['address']; ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?php echo $order['payment_method']; ?></p>
                    <p><strong>Ghi chú:</strong> <?php echo $order['note'] ? $order['note'] : 'Không có'; ?></p>
                </div>

                <h3>Danh sách sản phẩm</h3>
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($order_details): ?>
                        <?php foreach ($order_details as $detail): ?>
                        <tr>
                            <td><?php echo $detail['product']; ?></td>
                            <td><?php echo number_format($detail['price'], 0, ',', '.'); ?>đ</td>
                            <td><?php echo $detail['num']; ?></td>
                            <td><?php echo number_format($detail['total_money'], 0, ',', '.'); ?>đ</td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Tổng cộng:</td>
                            <td><?php echo number_format($order['total_money'], 0, ',', '.'); ?>đ</td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">Không có thông tin chi tiết về sản phẩm</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    <a href="tracuudonhang.php" class="order-detail-link">&laquo; Quay lại trang tra cứu</a>
                </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>Tổng đài hỗ trợ miễn phí</h3>
                    <ul class="footer-links">
                        <li>Mua hàng - bảo hành 1800.2097 (7h30 - 22h00)</li>
                        <li>Khiếu nại 1800.2063 (8h00 - 21h30)</li>
                    </ul>
                    <h3>Phương thức thanh toán</h3>
                    <div class="payment-methods">
                        <div class="payment-method"><img
                                src="https://cdn2.cellphones.com.vn/x35,webp/media/wysiwyg/apple-pay-og.png"
                                alt="Apple Pay"></div>
                        <div class="payment-method"><img
                                src="https://cdn2.cellphones.com.vn/x35,webp/media/logo/payment/vnpay-logo.png"
                                alt="VNPAY"></div>
                        <div class="payment-method"><img src="https://cdn2.cellphones.com.vn/x/media/wysiwyg/momo_1.png"
                                alt="Momo"></div>
                        <div class="payment-method"><img
                                src="https://cdn2.cellphones.com.vn/x35,webp/media/logo/payment/onepay-logo.png"
                                alt="OnePay"></div>
                        <div class="payment-method"><img
                                src="https://cdn2.cellphones.com.vn/x35,webp/media/logo/payment/zalopay-logo.png"
                                alt="ZaloPay"></div>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Thông tin và chính sách</h3>
                    <ul class="footer-links">
                        <li>Mua hàng và thanh toán Online</li>
                        <li>Mua hàng trả góp Online</li>
                        <li>Mua hàng trả góp bằng thẻ tín dụng</li>
                        <li>Chính sách giao hàng</li>
                        <li>Tra điểm Smember</li>
                        <li>Xem ưu đãi Smember</li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Dịch vụ và thông tin khác</h3>
                    <ul class="footer-links">
                        <li>Khách hàng doanh nghiệp (B2B)</li>
                        <li>Ưu đãi thanh toán</li>
                        <li>Quy chế hoạt động</li>
                        <li>Chính sách bảo mật thông tin cá nhân</li>
                        <li>Chính sách bảo hành</li>
                        <li>Liên hệ hợp tác kinh doanh</li>
                        <li>Tuyển dụng</li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Đăng ký nhận thông tin khuyến mại</h3>
                    <p>*Voucher sẽ được gửi sau 24h, chỉ áp dụng cho khách hàng mới</p>
                    <input type="email" placeholder="Nhập email của bạn"
                        style="padding: 10px; margin-bottom: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px;">
                    <input type="text" placeholder="Nhập số điện thoại của bạn"
                        style="padding: 10px; margin-bottom: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px;">
                    <div style="margin-bottom: 10px;">
                        <input type="checkbox" id="agree-terms" style="margin-right: 5px;">
                        <label for="agree-terms">Tôi đồng ý với <a href="#">điều khoản</a></label>

                    </div>
                    <button
                        style="padding: 10px 20px; background-color: #ff0000; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Đăng
                        ký</button>
                </div>
            </div>
        </div>
        <script>
        // Enhanced mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.menu-button');
            const sidebar = document.querySelector('.sidebar');

            // Toggle sidebar on menu button click
            menuButton.addEventListener('click', function() {
                sidebar.classList.toggle('active');

                // If sidebar is now active, make it visible
                if (sidebar.classList.contains('active')) {
                    sidebar.style.display = 'block';
                } else {
                    sidebar.style.display = 'none';
                }
            });

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !menuButton.contains(event.target) &&
                    sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    sidebar.style.display = 'none';
                }
            });

            // Handle responsive layout on resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768 && sidebar.style.display === 'none') {
                    sidebar.style.display = 'block';
                    sidebar.classList.remove('active');
                }
            });
        });
        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy các phần tử form
            const emailInput = document.querySelector('.footer-section input[type="email"]');
            const phoneInput = document.querySelector('.footer-section input[type="text"]');
            const termsCheckbox = document.getElementById('agree-terms');
            const registerButton = document.querySelector('.footer-section button');

            // Thêm sự kiện click cho nút đăng ký
            registerButton.addEventListener('click', function() {
                // Kiểm tra email trống
                if (!emailInput.value.trim()) {
                    showNotification('Vui lòng nhập email của bạn', 'error');
                    return;
                }

                // Kiểm tra định dạng email
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(emailInput.value.trim())) {
                    showNotification('Vui lòng nhập đúng định dạng email', 'error');
                    return;
                }

                // Kiểm tra số điện thoại trống
                if (!phoneInput.value.trim()) {
                    showNotification('Vui lòng nhập số điện thoại của bạn', 'error');
                    return;
                }

                // Kiểm tra định dạng số điện thoại Việt Nam
                // Kiểm tra số điện thoại có 10 chữ số, bắt đầu bằng 0
                // hoặc có 11 chữ số bắt đầu bằng 0
                // hoặc có 9 chữ số (không bắt đầu bằng 0)
                const phonePattern = /^(0[0-9]{9,10}|[1-9][0-9]{8})$/;
                if (!phonePattern.test(phoneInput.value.trim())) {
                    showNotification('Vui lòng nhập đúng số điện thoại Việt Nam (VD: 0912345678)',
                        'error');
                    return;
                }

                // Kiểm tra checkbox
                if (!termsCheckbox.checked) {
                    showNotification('Vui lòng đồng ý với điều khoản', 'error');
                    return;
                }

                // Nếu tất cả các điều kiện đều hợp lệ, hiển thị thông báo thành công
                showNotification(
                    'Đăng ký nhận thông tin khuyến mãi thành công! Vui lòng kiểm tra email của bạn.',
                    'success');

                // Đặt lại form
                emailInput.value = '';
                phoneInput.value = '';
                termsCheckbox.checked = false;
            });

            // Hàm hiển thị thông báo
            function showNotification(message, type) {
                // Xóa thông báo cũ nếu có
                const existingNotification = document.querySelector('.newsletter-notification');
                if (existingNotification) {
                    existingNotification.remove();
                }

                // Tạo phần tử thông báo
                const notification = document.createElement('div');
                notification.className = 'newsletter-notification';
                notification.textContent = message;

                // Định dạng dựa trên loại thông báo
                notification.style.position = 'fixed';
                notification.style.top = '50%';
                notification.style.left = '50%';
                notification.style.transform = 'translate(-50%, -50%)';
                notification.style.padding = '15px 20px';
                notification.style.borderRadius = '5px';
                notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
                notification.style.zIndex = '1000';
                notification.style.maxWidth = '350px';
                notification.style.fontWeight = '500';
                notification.style.textAlign = 'center';

                if (type === 'error') {
                    notification.style.backgroundColor = '#ff6b6b';
                    notification.style.color = 'white';
                } else {
                    notification.style.backgroundColor = '#51cf66';
                    notification.style.color = 'white';
                }

                // Thêm vào document
                document.body.appendChild(notification);

                // Xóa sau 3 giây
                setTimeout(function() {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.5s ease';

                    // Xóa khỏi DOM sau khi mờ dần
                    setTimeout(function() {
                        notification.remove();
                    }, 500);
                }, 3000);
            }
        });
        </script>
</body>

</html>