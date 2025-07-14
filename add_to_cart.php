<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Người dùng chưa đăng nhập, trả về phản hồi yêu cầu đăng nhập
    echo json_encode(['success' => false, 'login_required' => true]);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Get quantity from POST, default to 1 if not specified
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Ensure quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    // Check if product already exists in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Get product details from database
        include('./Config/ketnoi.php');
        $sql = "SELECT * FROM sanpham WHERE ma_sp = $product_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $_SESSION['cart'][$product_id] = [
                'id' => $product_id,
                'name' => $product['ten_sp'],
                'price' => $product['gia_sp'],
                'image' => $product['link_image'],
                'quantity' => $quantity
            ];
        }
        $conn->close();
    }
    
    // Return the total number of items in cart
    $total_items = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
    }
    
    echo json_encode(['success' => true, 'total_items' => $total_items]);
} else {
    echo json_encode(['success' => false]);
}
?>