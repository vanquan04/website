<?php
session_start();
include 'connect.php'; // Make sure this file exists with your database connection

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: loginadmin.php");
    exit();
}

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_status, $order_id);
    
    if ($stmt->execute()) {
        $success_message = "Trạng thái đơn hàng đã được cập nhật thành công!";
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật trạng thái đơn hàng: " . $conn->error;
    }
    
    $stmt->close();
}

// Handle order deletion
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // First delete order details
        $stmt = $conn->prepare("DELETE FROM order_details WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
        
        // Then delete the order
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
        
        // Commit transaction
        $conn->commit();
        $success_message = "Đơn hàng đã được xóa thành công!";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error_message = "Có lỗi xảy ra khi xóa đơn hàng: " . $e->getMessage();
    }
}

// Get orders with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$orders_per_page = 10;
$offset = ($page - 1) * $orders_per_page;

// Get total number of orders
$result = $conn->query("SELECT COUNT(*) as total FROM orders");
$row = $result->fetch_assoc();
$total_orders = $row['total'];
$total_pages = ceil($total_orders / $orders_per_page);

// Get orders for current page
$query = "SELECT * FROM orders ORDER BY order_date DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $offset, $orders_per_page);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-900 text-white p-5">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
            </div>
            
            <!-- User authentication status -->
            <div class="mt-6 pb-4 border-b border-blue-800">
                <?php if (isset($_SESSION['admin'])): ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-user-circle text-2xl mr-2"></i>
                            <span><?php echo $_SESSION['admin']['tendangnhap']; ?></span>
                        </div>
                        <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                        </a>
                    </div>
                <?php else: ?>
                    <a href="loginadmin.php" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
                    </a>
                <?php endif; ?>
            </div>
            
            <ul class="mt-5 space-y-3">
                <li class="p-2 hover:bg-blue-800 rounded transition-colors flex items-center">
                    <a href="index.php" class="flex items-center w-full">
                        <i class="fas fa-home mr-2"></i> Trang chủ
                    </a>
                </li>
                <li class="p-2 hover:bg-blue-800 rounded transition-colors flex items-center">
                    <a href="admin-product.php" class="flex items-center w-full">
                        <i class="fas fa-box mr-2"></i> Quản lý sản phẩm
                    </a>
                </li>
                <li class="p-2 hover:bg-blue-800 rounded transition-colors flex items-center">
                    <a href="admin-loaisp.php" class="flex items-center w-full">
                        <i class="fas fa-list mr-2"></i> Quản lý loại sản phẩm
                    </a>
                </li>
                <li class="p-2 bg-blue-700 rounded flex items-center">
                    <a href="admin-order.php" class="flex items-center w-full">
                        <i class="fas fa-file-invoice mr-2"></i> Quản lý đơn hàng
                    </a>
                </li>
                <li class="p-2 hover:bg-blue-800 rounded transition-colors flex items-center">
                    <a href="admin-manufacturer.php" class="flex items-center w-full">
                        <i class="fas fa-industry mr-2"></i> Quản lý nhà sản xuất
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-semibold">Quản lý đơn hàng</h1>
            </div>
            
            <!-- Status messages -->
            <?php if (isset($success_message)): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Orders Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Khách hàng</th>
                                <th class="py-3 px-4 text-left">Liên hệ</th>
                                <th class="py-3 px-4 text-left">Địa chỉ</th>
                                <th class="py-3 px-4 text-left">Tổng tiền</th>
                                <th class="py-3 px-4 text-left">Ngày đặt</th>
                                <th class="py-3 px-4 text-left">Trạng thái</th>
                                <th class="py-3 px-4 text-left">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="8" class="py-4 px-4 text-center">Không có đơn hàng nào</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr class="hover:bg-gray-100 border-b">
                                        <td class="py-3 px-4"><?php echo $order['id']; ?></td>
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($order['fullname']); ?></td>
                                        <td class="py-3 px-4">
                                            <div><?php echo htmlspecialchars($order['email']); ?></div>
                                            <div><?php echo htmlspecialchars($order['phone_number']); ?></div>
                                        </td>
                                        <td class="py-3 px-4"><?php echo htmlspecialchars($order['address']); ?></td>
                                        <td class="py-3 px-4"><?php echo number_format($order['total_money'], 0, ',', '.'); ?> đ</td>
                                        <td class="py-3 px-4"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                                        <td class="py-3 px-4">
                                            <?php
                                            switch ($order['status']) {
                                                case 0:
                                                    echo '<span class="bg-yellow-200 text-yellow-800 py-1 px-2 rounded-full text-xs">Chờ xử lý</span>';
                                                    break;
                                                case 1:
                                                    echo '<span class="bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">Đang xử lý</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="bg-green-200 text-green-800 py-1 px-2 rounded-full text-xs">Đã giao hàng</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="bg-red-200 text-red-800 py-1 px-2 rounded-full text-xs">Đã hủy</span>';
                                                    break;
                                                default:
                                                    echo '<span class="bg-gray-200 text-gray-800 py-1 px-2 rounded-full text-xs">Không xác định</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex space-x-2">
                                                <button onclick="toggleOrderDetails(<?php echo $order['id']; ?>)" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                                    <i class="fas fa-eye"></i> Chi tiết
                                                </button>
                                                
                                                <button onclick="showStatusUpdateForm(<?php echo $order['id']; ?>)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                                                    <i class="fas fa-edit"></i> Cập nhật
                                                </button>
                                                
                                                <form action="" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                    <button type="submit" name="delete_order" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Order Details Row (Hidden by default) -->
                                    <tr id="order-details-<?php echo $order['id']; ?>" class="hidden bg-gray-50">
                                        <td colspan="8" class="py-4 px-4">
                                            <div class="text-lg font-semibold mb-2">Chi tiết đơn hàng #<?php echo $order['id']; ?></div>
                                            
                                            <?php
                                            // Get order details
                                            $query = "SELECT * FROM order_details WHERE order_id = ?";
                                            $stmt = $conn->prepare($query);
                                            $stmt->bind_param("i", $order['id']);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $order_details = $result->fetch_all(MYSQLI_ASSOC);
                                            $stmt->close();
                                            ?>
                                            
                                            <table class="min-w-full bg-white border">
                                                <thead class="bg-gray-200">
                                                    <tr>
                                                        <th class="py-2 px-4 text-left">Sản phẩm</th>
                                                        <th class="py-2 px-4 text-left">Đơn giá</th>
                                                        <th class="py-2 px-4 text-left">Số lượng</th>
                                                        <th class="py-2 px-4 text-left">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order_details as $detail): ?>
                                                        <tr class="border-b">
                                                            <td class="py-2 px-4"><?php echo htmlspecialchars($detail['product']); ?></td>
                                                            <td class="py-2 px-4"><?php echo number_format($detail['price'], 0, ',', '.'); ?> đ</td>
                                                            <td class="py-2 px-4"><?php echo $detail['num']; ?></td>
                                                            <td class="py-2 px-4"><?php echo number_format($detail['total_money'], 0, ',', '.'); ?> đ</td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot class="bg-gray-100">
                                                    <tr></tr><!-- Tfoot (continued) -->
                                    <tr>
                                        <td colspan="3" class="py-2 px-4 text-right font-semibold">Tổng cộng:</td>
                                        <td class="py-2 px-4 font-semibold"><?php echo number_format($order['total_money'], 0, ',', '.'); ?> đ</td>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <!-- Payment & Delivery Info -->
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border">
                                    <h3 class="font-semibold text-lg mb-2">Thông tin thanh toán</h3>
                                    <p><span class="font-medium">Phương thức:</span> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                                    <p><span class="font-medium">Trạng thái:</span> 
                                        <?php echo $order['status'] == 2 ? 'Đã thanh toán' : 'Chưa thanh toán'; ?>
                                    </p>
                                </div>
                                
                                <div class="bg-white p-4 rounded-lg border">
                                    <h3 class="font-semibold text-lg mb-2">Thông tin giao hàng</h3>
                                    <p><span class="font-medium">Người nhận:</span> <?php echo htmlspecialchars($order['fullname']); ?></p>
                                    <p><span class="font-medium">Địa chỉ:</span> <?php echo htmlspecialchars($order['address']); ?></p>
                                    <p><span class="font-medium">Số điện thoại:</span> <?php echo htmlspecialchars($order['phone_number']); ?></p>
                                    <p><span class="font-medium">Email:</span> <?php echo htmlspecialchars($order['email']); ?></p>
                                </div>
                            </div>
                            
                            <?php if (!empty($order['note'])): ?>
                            <div class="mt-4 bg-white p-4 rounded-lg border">
                                <h3 class="font-semibold text-lg mb-2">Ghi chú</h3>
                                <p><?php echo htmlspecialchars($order['note']); ?></p>
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <!-- Status Update Form (Hidden by default) -->
                    <tr id="status-update-form-<?php echo $order['id']; ?>" class="hidden bg-gray-50">
                        <td colspan="8" class="py-4 px-4">
                            <form action="" method="post" class="bg-white p-4 rounded-lg border">
                                <h3 class="font-semibold text-lg mb-4">Cập nhật trạng thái đơn hàng #<?php echo $order['id']; ?></h3>
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2">Trạng thái hiện tại:</label>
                                    <?php
                                    switch ($order['status']) {
                                        case 0:
                                            echo '<span class="bg-yellow-200 text-yellow-800 py-1 px-2 rounded-full text-xs">Chờ xử lý</span>';
                                            break;
                                        case 1:
                                            echo '<span class="bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">Đang xử lý</span>';
                                            break;
                                        case 2:
                                            echo '<span class="bg-green-200 text-green-800 py-1 px-2 rounded-full text-xs">Đã giao hàng</span>';
                                            break;
                                        case 3:
                                            echo '<span class="bg-red-200 text-red-800 py-1 px-2 rounded-full text-xs">Đã hủy</span>';
                                            break;
                                        default:
                                            echo '<span class="bg-gray-200 text-gray-800 py-1 px-2 rounded-full text-xs">Không xác định</span>';
                                    }
                                    ?>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="new_status" class="block text-gray-700 mb-2">Cập nhật thành:</label>
                                    <select name="new_status" id="new_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                        <option value="0" <?php echo $order['status'] == 0 ? 'selected' : ''; ?>>Chờ xử lý</option>
                                        <option value="1" <?php echo $order['status'] == 1 ? 'selected' : ''; ?>>Đang xử lý</option>
                                        <option value="2" <?php echo $order['status'] == 2 ? 'selected' : ''; ?>>Đã giao hàng</option>
                                        <option value="3" <?php echo $order['status'] == 3 ? 'selected' : ''; ?>>Đã hủy</option>
                                    </select>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="button" onclick="hideStatusUpdateForm(<?php echo $order['id']; ?>)" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
                                        Hủy
                                    </button>
                                    <button type="submit" name="update_status" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                        Cập nhật
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<div class="mt-6 flex justify-center">
    <div class="flex space-x-1">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                <i class="fas fa-chevron-left"></i>
            </a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="px-4 py-2 <?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'; ?> rounded hover:bg-gray-300">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

</div>
</div>

<script>
function toggleOrderDetails(orderId) {
    var detailsRow = document.getElementById('order-details-' + orderId);
    if (detailsRow.classList.contains('hidden')) {
        detailsRow.classList.remove('hidden');
    } else {
        detailsRow.classList.add('hidden');
    }
}

function showStatusUpdateForm(orderId) {
    var formRow = document.getElementById('status-update-form-' + orderId);
    formRow.classList.remove('hidden');
}

function hideStatusUpdateForm(orderId) {
    var formRow = document.getElementById('status-update-form-' + orderId);
    formRow.classList.add('hidden');
}
</script>

</body>
</html>