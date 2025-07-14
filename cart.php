<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle quantity updates
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    // Redirect to avoid form resubmission
    header('Location: cart.php');
    exit;
}

// Handle item removal
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header('Location: cart.php');
    exit;
}

// Calculate cart totals
$total_items = 0;
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_items += $item['quantity'];
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - realphoneA</title>
    <link rel="stylesheet" href="css/index.css">
    <style>
        .cart-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .cart-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #d70018;
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .cart-table th {
            background-color: #f5f5f5;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .cart-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        
        .quantity-input {
            width: 50px;
            padding: 5px;
            text-align: center;
        }
        
        .remove-btn {
            background-color: #d70018;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .cart-summary {
            text-align: right;
            margin-top: 20px;
        }
        
        .update-cart-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
        }
        
        .checkout-btn {
            background-color: #d70018;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .continue-shopping {
            margin-top: 20px;
        }
        
        .continue-shopping a {
            color: #333;
            text-decoration: none;
        }
        
        .empty-cart {
            text-align: center;
            margin: 50px 0;
            color: #777;
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
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            Danh mục
        </button>
        
        <div class="search-box">
    <form action="search.php" method="GET">
        <input type="text" name="keyword" placeholder="Bạn cần tìm gì?" required>
        <button type="submit" style="display: flex; background-color: red; color: #fff;padding: 0 10px; border: none; border-radius: 5px; cursor: pointer;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </button>
    </form>
</div>
        <div class="header-icons">
        <div class="icon-button">
    <a href="tracuudonhang.php" style="text-decoration: none; color: white;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
            <polygon points="12 15 17 21 7 21 12 15"></polygon>
        </svg>
        <br>Tra cứu đơn hàng
    </a>
</div>
            <div class="icon-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                Giỏ hàng
                <span class="cart-counter" style="position: absolute; top: -5px; right: -5px; background-color: yellow; color: black; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px;"><?php echo $total_items; ?></span>
            </div>
            <div class="icon-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
        
    
    <!-- Cart Container -->
    <div class="cart-container">
        <h1 class="cart-title">Giỏ hàng của bạn</h1>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <h2>Giỏ hàng của bạn đang trống</h2>
                <p>Hãy tiếp tục mua sắm để thêm sản phẩm vào giỏ hàng.</p>
                <a href="index.php" class="checkout-btn" style="display: inline-block; margin-top: 20px; text-decoration: none;">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <form method="post" action="cart.php">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="product-image">
                                </td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo number_format($item['price']); ?> VND</td>
                                <td>
                                    <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                                </td>
                                <td><?php echo number_format($item['price'] * $item['quantity']); ?> VND</td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $product_id; ?>" class="remove-btn">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="cart-summary">
                    <h3>Tổng tiền: <?php echo number_format($total_price); ?> VND</h3>
                    <button type="submit" name="update_cart" class="update-cart-btn">Cập nhật giỏ hàng</button>
                    <a href="checkout.php" class="checkout-btn" style="text-decoration: none;">Thanh toán</a>
                </div>
            </form>
            
            <div class="continue-shopping">
                <a href="index.php">← Tiếp tục mua sắm</a>
            </div>
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
                    <div class="payment-method"><img src="https://cdn2.cellphones.com.vn/x35,webp/media/wysiwyg/apple-pay-og.png" alt="Apple Pay"></div>
                    <div class="payment-method"><img src="https://cdn2.cellphones.com.vn/x35,webp/media/logo/payment/vnpay-logo.png" alt="VNPAY"></div>
                    <div class="payment-method"><img src="https://cdn2.cellphones.com.vn/x/media/wysiwyg/momo_1.png" alt="Momo"></div>
                    <div class="payment-method"><img src="https://cdn2.cellphones.com.vn/x35,webp/media/logo/payment/onepay-logo.png" alt="OnePay"></div>
                    <div class="payment-method"><img src="https://cdn2.cellphones.com.vn/x35,webp/media/logo/payment/zalopay-logo.png" alt="ZaloPay"></div>
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
                <input type="email" placeholder="Nhập email của bạn" style="padding: 10px; margin-bottom: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px;">
                <input type="text" placeholder="Nhập số điện thoại của bạn" style="padding: 10px; margin-bottom: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px;">
                <div style="margin-bottom: 10px;">
                    <input type="checkbox" id="agree-terms" style="margin-right: 5px;">
                    <label for="agree-terms">Tôi đồng ý với <a href="#">điều khoản</a></label>
                </div>
                <button style="padding: 10px 20px; background-color: #ff0000; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Đăng ký</button>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle sidebar visibility when menu button is clicked
        document.querySelector('.menu-button').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            
            // Toggle visibility
            if (sidebar.style.display === 'none' || getComputedStyle(sidebar).display === 'none') {
                sidebar.style.display = 'block';
                sidebar.classList.add('active');
            } else {
                sidebar.style.display = 'none';
                sidebar.classList.remove('active');
            }
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
            showNotification('Vui lòng nhập đúng số điện thoại Việt Nam (VD: 0912345678)', 'error');
            return;
        }
        
        // Kiểm tra checkbox
        if (!termsCheckbox.checked) {
            showNotification('Vui lòng đồng ý với điều khoản', 'error');
            return;
        }
        
        // Nếu tất cả các điều kiện đều hợp lệ, hiển thị thông báo thành công
        showNotification('Đăng ký nhận thông tin khuyến mãi thành công! Vui lòng kiểm tra email của bạn.', 'success');
        
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