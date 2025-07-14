<?php
session_start();

$logged_in = isset($_SESSION['user']);
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>realphoneA - Điện thoại, phụ kiện chính hãng</title>
    <link rel="stylesheet" href="css/sanpham.css">
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
                    <a href="cart.php" style="text-decoration: none; color: white;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
     <!-- Main Content -->
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
    <div class="container">
        <div class="product-header">
            <h1 class="product-title">iPhone 16e 128GB | Chính hàng VN/A</h1>
            <div class="rating">★★★★★</div>
            <span class="reviews">30 đánh giá</span>
        </div>
        
        <div class="product-container">
            <div class="product-gallery">
                <div class="wishlist-icon">❤</div>
                <div class="main-image">
                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16e-128gb_1_.png" alt="iPhone 16e">
                </div>
                <div class="product-features">
                    <h2 class="feature-title">TÍNH NĂNG NỔI BẬT</h2>
                    <ul class="feature-list">
                        <li>iPhone 16e được trang bị chip xử lý Apple A18 mạnh mẽ, mang đến khả năng xử lý mượt mà mọi tác vụ hàng ngày, từ công việc đến giải trí.</li>
                        <li>Màn hình Super Retina XDR với độ phân giải 2532x1170 pixel mang lại chất lượng hình ảnh, sắc nét, chân thực và sống động.</li>
                        <li>Dung lượng pin lớn lên đến 26 giờ sử dụng cho bạn thoải mái trải nghiệm cả ngày dài.</li>
                    </ul>
                </div>
                
                <div class="thumbnail-container">
                    <div class="thumbnail active">
                        <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16e-128gb.png" alt="iPhone 16e Thumbnail 1">
                    </div>
                    <div class="thumbnail">
                        <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16e-128gb_2_.png" alt="iPhone 16e Thumbnail 2">
                    </div>
                    <div class="thumbnail">
                        <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16e-128gb_3_.png" alt="iPhone 16e Thumbnail 3">
                    </div>
                    <div class="thumbnail">
                        <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16e-128gb_4_.png" alt="iPhone 16e Thumbnail 4">
                    </div>
                    <div class="thumbnail">
                        <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16e-128gb_5_.png" alt="iPhone 16e Thumbnail 5">
                    </div>
                    <div class="thumbnail">
                        <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16e-128gb_6_.png" alt="iPhone 16e Thumbnail 6">
                    </div>
                </div>
            </div>
            
            <div class="product-info">
                <div class="storage-options">
                    <div class="storage-option ">
                        <div class="storage-size">128GB</div>
                        <div class="storage-price">16.490.000 đ</div>
                    </div>
                </div>
                
                <div class="color-selection">
                    <div class="color-options">
                        
                        <div class="color-option ">
                            <div class="color-circle white"></div>
                            <div class="color-details">
                                <span class="color-name">Trắng</span>
                                <span class="color-price">16.490.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="price-container">
                    <div class="main-price">
                        <div class="price-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#333"/>
                            </svg>
                            <div>
                                <div class="trade-in-price">15.490.000đ</div>
                                <div class="trade-in-text">Khi thu cũ lên đời</div>
                            </div>
                        </div>
                        <div>
                            <div class="current-price">16.490.000đ</div>
                            <div class="original-price">16.990.000đ</div>
                        </div>
                    </div>
                    
                    <div class="savings">
                        <span class="savings-text">Tiết kiệm thêm đến <span class="savings-amount">165.000đ</span> cho Smember</span>
                    </div>
                    
                    <a href="#" class="check-price-link">
                        Kiểm tra giá cuối cùng của bạn
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6L16 12L10 18L8.59 16.59Z" fill="#f00"/>
                        </svg>
                    </a>
                </div>
                
                <div class="promo-banner">
                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:120/q:90/plain/https://dashboard.cellphones.com.vn/storage/qua-tang-8-3.png" alt="Promotion Banner">
                </div>
                

                <div class="installment-options">
                    <div class="installment-option">
                        <div class="installment-title">TRẢ GÓP 0%</div>
                        <div class="installment-details">Trả trước chỉ từ 1.699.000đ</div>
                    </div>
                    <div class="installment-option">
                        <div class="installment-title">TRẢ GÓP 0% QUA THẺ</div>
                        <div class="installment-details">(Không phí chuyển đổi 3 - 6 tháng)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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
                    <label for="agree-terms">Tôi đồng ý với <a href="#" >điều khoản</a></label>
                    
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
document.addEventListener('DOMContentLoaded', function() {
    // Update cart counter on page load
    updateCartCounter();
    
    // Add event listeners to all "Add to cart" buttons
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            addToCart(productId);
        });
    });
    
    // Function to add product to cart
function addToCart(productId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_to_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            
            // Check if login is required
            if (response.login_required) {
                // Show login notification before redirecting
                showLoginNotification('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
                
                // Redirect to login page after a short delay
                setTimeout(function() {
                    window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
                }, 2000); // 2 second delay
                return;
            }
            
            if (response.success) {
                updateCartCounter(response.total_items);
                // Show notification
                showNotification('Sản phẩm đã được thêm vào giỏ hàng!');
            }
        }
    };
    xhr.send('product_id=' + productId);
}
    
    // Function to update cart counter
    function updateCartCounter(count) {
        const cartIcon = document.querySelector('.icon-button:nth-child(2)');
        
        // If count is not provided, get it from session
        if (!count) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_cart_count.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    updateCartDisplay(response.count);
                }
            };
            xhr.send();
        } else {
            updateCartDisplay(count);
        }
    }
    
    function updateCartDisplay(count) {
        const cartIcon = document.querySelector('.icon-button:nth-child(2)');
        let cartCounter = cartIcon.querySelector('.cart-counter');
        
        if (!cartCounter) {
            cartCounter = document.createElement('span');
            cartCounter.className = 'cart-counter';
            cartCounter.style.position = 'absolute';
            cartCounter.style.top = '-5px';
            cartCounter.style.right = '-5px';
            cartCounter.style.backgroundColor = 'yellow';
            cartCounter.style.color = 'black';
            cartCounter.style.borderRadius = '50%';
            cartCounter.style.width = '20px';
            cartCounter.style.height = '20px';
            cartCounter.style.display = 'flex';
            cartCounter.style.alignItems = 'center';
            cartCounter.style.justifyContent = 'center';
            cartCounter.style.fontSize = '12px';
            cartIcon.appendChild(cartCounter);
        }
        
        if (count > 0) {
            cartCounter.textContent = count;
            cartCounter.style.display = 'flex';
        } else {
            cartCounter.style.display = 'none';
        }
    }
    
   
// Function to show login notification
function showLoginNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'login-notification';
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '50%';
    notification.style.left = '50%';
    notification.style.transform = 'translate(-50%, -50%)';
    notification.style.backgroundColor = '#ff6b6b';
    notification.style.color = 'white';
    notification.style.padding = '20px';
    notification.style.borderRadius = '5px';
    notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
    notification.style.zIndex = '1000';
    notification.style.textAlign = 'center';
    notification.style.minWidth = '300px';
    notification.style.opacity = '0';
    notification.style.transition = 'opacity 0.3s';
    
    document.body.appendChild(notification);
    
    // Fade in
    setTimeout(() => {
        notification.style.opacity = '1';
    }, 10);
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