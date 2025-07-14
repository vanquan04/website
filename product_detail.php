<?php
session_start();
include('./Config/ketnoi.php');
// Get product ID from URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Validate product ID
if (!is_numeric($product_id) || $product_id <= 0) {
    header("Location: index.php");
    exit;
}

// Get product details from database
$sql = "SELECT * FROM sanpham WHERE ma_sp = $product_id";
$result = $conn->query($sql);

// Check if product exists
if ($result->num_rows == 0) {
    header("Location: index.php");
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['ten_sp']; ?> - realphoneA</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/demosp.css">
    <style>
    .product-detail-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-detail {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }

    .product-images {
        flex: 1;
        min-width: 300px;
    }

    .product-images img {
        width: 100%;
        border-radius: 8px;
    }

    .product-info {
        flex: 1;
        min-width: 300px;
    }

    .product-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .product-code {
        color: #777;
        margin-bottom: 20px;
    }

    .product-price {
        font-size: 28px;
        font-weight: bold;
        color: #cd1818;
        margin-bottom: 10px;
    }

    .original-price {
        text-decoration: line-through;
        color: #777;
        font-size: 18px;
        margin-bottom: 20px;
    }

    .product-actions {
        display: flex;
        gap: 15px;
        margin: 30px 0;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .quantity-btn {
        background: #f5f5f5;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 18px;
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        border: none;
        font-size: 16px;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        padding: 12px 30px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart-btn {
        background-color: #fff;
        color: #cd1818;
        border: 2px solid #cd1818;
    }

    .add-to-cart-btn:hover {
        background-color: #f8e6e6;
    }



    .product-description {
        margin-top: 40px;
    }

    .product-description h3 {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-size: 20px;
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background-color: #51cf66;
        color: white;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .notification.show {
        opacity: 1;
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
                    $count = 0;
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $count += $item['quantity'];
                        }
                    }
                    if ($count > 0) {
                        echo '<span class="cart-counter" style="position: absolute; top: -5px; right: -5px; background-color: yellow; color: black; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px;">' . $count . '</span>';
                    }
                    ?>
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


        <!-- Product Detail Content -->
        <div class="product-detail-container">
            <div class="product-detail">
                <div class="product-images">
                    <img src="<?php echo $product['link_image']; ?>" alt="<?php echo $product['ten_sp']; ?>">
                </div>
                <div class="product-info">
                    <div class="product-title"><?php echo $product['ten_sp']; ?></div>
                    <div class="product-code">Mã sản phẩm: <?php echo $product['ma_sp']; ?></div>

                    <div class="product-price"><?php echo number_format($product['gia_sp']); ?> đ</div>
                    <?php 
                // If there's a discount, show original price
                $discount = 0.05; // 5% discount for example
                $originalPrice = $product['gia_sp'] / (1 - $discount);
                echo '<div class="original-price">' . number_format($originalPrice) . ' đ</div>';
                ?>

                    <div class="product-actions">
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="10">
                            <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>

                        <button class="add-to-cart-btn" onclick="addToCart(<?php echo $product['ma_sp']; ?>)">
                            THÊM VÀO GIỎ
                        </button>


                    </div>

                    <div class="product-description">
                        <h3>Mô tả sản phẩm</h3>
                        <p><?php echo $product['mo_ta'] ?? 'Đang cập nhật mô tả sản phẩm...'; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification -->
        <div id="notification" class="notification"></div>

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

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const menuButton = document.querySelector('.menu-button');

            if (!sidebar.contains(event.target) && !menuButton.contains(event.target) &&
                (sidebar.style.display === 'block' || getComputedStyle(sidebar).display === 'block')) {
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
        <script>
        // Functions to handle quantity
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < 10) { // Max limit set to 10
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) { // Min limit is 1
                quantityInput.value = currentValue - 1;
            }
        }

        // Function to add to cart with selected quantity
        function addToCart(productId) {
            const quantity = parseInt(document.getElementById('quantity').value);

            // Create FormData to send
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            // Use fetch API to send data to add_to_cart.php
            fetch('add_to_cart.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart counter
                        const cartCounter = document.querySelector('.cart-counter');
                        if (cartCounter) {
                            cartCounter.textContent = data.total_items;
                            cartCounter.style.display = 'flex';
                        } else {
                            // Create new counter if it doesn't exist
                            const iconButton = document.querySelector('.icon-button a');
                            const newCounter = document.createElement('span');
                            newCounter.className = 'cart-counter';
                            newCounter.textContent = data.total_items;
                            newCounter.style.position = 'absolute';
                            newCounter.style.top = '-5px';
                            newCounter.style.right = '-5px';
                            newCounter.style.backgroundColor = 'yellow';
                            newCounter.style.color = 'black';
                            newCounter.style.borderRadius = '50%';
                            newCounter.style.width = '20px';
                            newCounter.style.height = '20px';
                            newCounter.style.display = 'flex';
                            newCounter.style.alignItems = 'center';
                            newCounter.style.justifyContent = 'center';
                            newCounter.style.fontSize = '12px';
                            iconButton.appendChild(newCounter);
                        }

                        // Show success notification
                        showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                    } else if (data.login_required) {
                        // Redirect to login page if not logged in
                        window.location.href = 'login.php';
                    } else {
                        // Show error notification
                        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
                });
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;
            notification.style.position = 'fixed';
            notification.style.top = '50%';
            notification.style.left = '50%';
            notification.style.transform = 'translate(-50%, -50%)';
            notification.style.backgroundColor = '#4CAF50';
            notification.style.color = 'white';
            notification.style.padding = '8px 12px'; // Giảm padding nhiều hơn
            notification.style.borderRadius = '4px';
            notification.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';
            notification.style.zIndex = '1000';
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            notification.style.fontSize = '14px';
            notification.style.width = 'auto'; // Để width tự điều chỉnh theo nội dung
            notification.style.maxWidth = '250px'; // Giảm maxWidth
            notification.style.textAlign = 'center';
            notification.style.height = 'auto'; // Chiều cao tự điều chỉnh theo nội dung
            notification.style.lineHeight = '1.2'; // Giảm khoảng cách giữa các dòng

            document.body.appendChild(notification);

            // Fade in
            setTimeout(() => {
                notification.style.opacity = '1';
            }, 10);

            // Fade out after 1.5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';

                // Remove from DOM after fade out
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 1500); // Giảm thời gian hiển thị xuống 1.5 giây
        }
        </script>

</body>

</html>