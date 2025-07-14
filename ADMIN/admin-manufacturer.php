<?php
session_start();
include "connect.php";
// Check if user is logged in
$isLoggedIn = isset($_SESSION['admin']);

// Process form submissions
if ($isLoggedIn) {
    // Add new manufacturer
    if (isset($_POST['add_manufacturer'])) {
        $ten_nxs = $_POST['ten_nxs'];
        
        // Validate input
        if (!empty($ten_nxs)) {
            $sql = "INSERT INTO nhasanxuat (ten_nxs) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $ten_nxs);
            
            if ($stmt->execute()) {
                $successMessage = "Thêm nhà sản xuất thành công!";
            } else {
                $errorMessage = "Lỗi: " . $conn->error;
            }
            $stmt->close();
        } else {
            $errorMessage = "Vui lòng nhập tên nhà sản xuất!";
        }
    }
    
    // Update manufacturer
    if (isset($_POST['update_manufacturer'])) {
        $ma_nxs = $_POST['ma_nxs'];
        $ten_nxs = $_POST['ten_nxs'];
        
        // Validate input
        if (!empty($ten_nxs)) {
            $sql = "UPDATE nhasanxuat SET ten_nxs = ? WHERE ma_nxs = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $ten_nxs, $ma_nxs);
            
            if ($stmt->execute()) {
                $successMessage = "Cập nhật nhà sản xuất thành công!";
            } else {
                $errorMessage = "Lỗi: " . $conn->error;
            }
            $stmt->close();
        } else {
            $errorMessage = "Vui lòng nhập tên nhà sản xuất!";
        }
    }
    
    // Delete manufacturer
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $ma_nxs = $_GET['delete'];
        
        // Check if manufacturer is used in products
        $check_sql = "SELECT COUNT(*) as count FROM sanpham WHERE ma_nsx = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $ma_nxs);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $row = $result->fetch_assoc();
        $check_stmt->close();
        
        if ($row['count'] > 0) {
            $errorMessage = "Không thể xóa nhà sản xuất này vì đang được sử dụng trong sản phẩm!";
        } else {
            $sql = "DELETE FROM nhasanxuat WHERE ma_nxs = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $ma_nxs);
            
            if ($stmt->execute()) {
                $successMessage = "Xóa nhà sản xuất thành công!";
            } else {
                $errorMessage = "Lỗi: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Fetch manufacturers for display
$sql = "SELECT * FROM nhasanxuat ORDER BY ma_nxs DESC";
$result = $conn->query($sql);
$manufacturers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $manufacturers[] = $row;
    }
}

// Get manufacturer details for editing
$editManufacturer = null;
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $ma_nxs = $_GET['edit'];
    $sql = "SELECT * FROM nhasanxuat WHERE ma_nxs = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_nxs);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $editManufacturer = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhà sản xuất</title>
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
                <?php if ($isLoggedIn): ?>
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
                <li class="p-2 hover:bg-blue-800 rounded transition-colors flex items-center">
                    <a href="admin-order.php" class="flex items-center w-full">
                        <i class="fas fa-file-invoice mr-2"></i> Quản lý đơn hàng
                    </a>
                </li>
                <li class="p-2 bg-blue-700 rounded flex items-center">
                    <a href="admin-manufacturer.php" class="flex items-center w-full">
                        <i class="fas fa-industry mr-2"></i> Quản lý nhà sản xuất
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-semibold">Quản lý nhà sản xuất</h1>
                
                <!-- Mobile logout button (visible on small screens) -->
                <?php if ($isLoggedIn): ?>
                <div class="block md:hidden">
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Access check message -->
            <?php if (!$isLoggedIn): ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                    <p>Bạn cần đăng nhập để truy cập đầy đủ tính năng quản trị.</p>
                </div>
            <?php else: ?>
                <!-- Success and Error Messages -->
                <?php if (isset($successMessage)): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        <p><?php echo $successMessage; ?></p>
                    </div>
                <?php endif; ?>
                <?php if (isset($errorMessage)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <p><?php echo $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                
                <!-- Manufacturer Form -->
                <div class="bg-white p-6 rounded shadow-md mb-6">
                    <h2 class="text-xl font-semibold mb-4">
                        <?php echo $editManufacturer ? 'Sửa nhà sản xuất' : 'Thêm nhà sản xuất mới'; ?>
                    </h2>
                    <form method="post" action="">
                        <?php if ($editManufacturer): ?>
                            <input type="hidden" name="ma_nxs" value="<?php echo $editManufacturer['ma_nxs']; ?>">
                        <?php endif; ?>
                        <div class="mb-4">
                            <label for="ten_nxs" class="block text-sm font-medium text-gray-700 mb-2">Tên nhà sản xuất</label>
                            <input type="text" id="ten_nxs" name="ten_nxs" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="<?php echo $editManufacturer ? $editManufacturer['ten_nxs'] : ''; ?>" required>
                        </div>
                        <div class="flex justify-end">
                            <?php if ($editManufacturer): ?>
                                <button type="submit" name="update_manufacturer" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors">
                                    Cập nhật
                                </button>
                                <a href="admin-manufacturer.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors ml-2">
                                    Hủy
                                </a>
                            <?php else: ?>
                                <button type="submit" name="add_manufacturer" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-colors">
                                    Thêm mới
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <!-- Manufacturers List -->
                <div class="bg-white p-6 rounded shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Danh sách nhà sản xuất</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">ID</th>
                                    <th class="py-2 px-4 border-b text-left">Tên nhà sản xuất</th>
                                    <th class="py-2 px-4 border-b text-right">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($manufacturers) > 0): ?>
                                    <?php foreach ($manufacturers as $manufacturer): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-2 px-4 border-b"><?php echo $manufacturer['ma_nxs']; ?></td>
                                            <td class="py-2 px-4 border-b"><?php echo $manufacturer['ten_nxs']; ?></td>
                                            <td class="py-2 px-4 border-b text-right">
                                                <a href="?edit=<?php echo $manufacturer['ma_nxs']; ?>" class="text-blue-500 hover:text-blue-700 mr-2">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="?delete=<?php echo $manufacturer['ma_nxs']; ?>" class="text-red-500 hover:text-red-700" 
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa nhà sản xuất này?');">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="py-4 px-4 text-center text-gray-500">Không có nhà sản xuất nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>