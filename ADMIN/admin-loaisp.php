<?php
session_start();
include("connect.php"); // Assuming you have a config file for database connection

// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: loginadmin.php");
    exit();
}

// Handle category deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $ma_lsp = $_GET['delete'];
    $conn->query("DELETE FROM loaisanpham WHERE ma_lsp = $ma_lsp");
    header("Location: admin-loaisp.php");
    exit();
}

// Handle category addition
if (isset($_POST['add_category'])) {
    $ten_lsp = $conn->real_escape_string($_POST['ten_lsp']);
    $mota_lsp = $conn->real_escape_string($_POST['mota_lsp']);
    
    $conn->query("INSERT INTO loaisanpham (ten_lsp, mota_lsp) VALUES ('$ten_lsp', '$mota_lsp')");
    header("Location: admin-loaisp.php");
    exit();
}

// Handle category update
if (isset($_POST['update_category'])) {
    $ma_lsp = $_POST['ma_lsp'];
    $ten_lsp = $conn->real_escape_string($_POST['ten_lsp']);
    $mota_lsp = $conn->real_escape_string($_POST['mota_lsp']);
    
    $conn->query("UPDATE loaisanpham SET ten_lsp = '$ten_lsp', mota_lsp = '$mota_lsp' WHERE ma_lsp = $ma_lsp");
    header("Location: admin-loaisp.php");
    exit();
}

// Get all categories
$result = $conn->query("SELECT * FROM loaisanpham ORDER BY ma_lsp");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý loại sản phẩm - Admin Dashboard</title>
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
                <li class="p-2 bg-blue-700 rounded flex items-center">
                    <a href="admin-loaisp.php" class="flex items-center w-full">
                        <i class="fas fa-tags mr-2"></i> Quản lý loại sản phẩm
                    </a>
                </li>
                <li class="p-2 hover:bg-blue-800 rounded transition-colors flex items-center">
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
                <h1 class="text-3xl font-semibold">Quản lý loại sản phẩm</h1>
                
                <!-- Mobile logout button (visible on small screens) -->
                <?php if (isset($_SESSION['admin'])): ?>
                <div class="block md:hidden">
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Add New Category Form -->
            <div class="bg-white p-6 rounded shadow-md mb-6">
                <h2 class="text-xl font-semibold mb-4">Thêm loại sản phẩm mới</h2>
                <form action="" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="ten_lsp" class="block text-sm font-medium text-gray-700 mb-1">Tên loại sản phẩm</label>
                            <input type="text" id="ten_lsp" name="ten_lsp" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="mota_lsp" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                            <input type="text" id="mota_lsp" name="mota_lsp" 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="add_category" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            <i class="fas fa-plus mr-2"></i> Thêm loại sản phẩm
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Edit Category Form (hidden by default, shown when editing) -->
            <div id="edit-form" class="bg-white p-6 rounded shadow-md mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Chỉnh sửa loại sản phẩm</h2>
                <form action="" method="post">
                    <input type="hidden" id="edit_ma_lsp" name="ma_lsp">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_ten_lsp" class="block text-sm font-medium text-gray-700 mb-1">Tên loại sản phẩm</label>
                            <input type="text" id="edit_ten_lsp" name="ten_lsp" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="edit_mota_lsp" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                            <input type="text" id="edit_mota_lsp" name="mota_lsp" 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-2">
                        <button type="submit" name="update_category" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            <i class="fas fa-save mr-2"></i> Lưu thay đổi
                        </button>
                        <button type="button" onclick="hideEditForm()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            <i class="fas fa-times mr-2"></i> Hủy
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Categories List -->
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-semibold mb-4">Danh sách loại sản phẩm</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 tracking-wider">ID</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 tracking-wider">Tên loại sản phẩm</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 tracking-wider">Mô tả</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"><?php echo $row['ma_lsp']; ?></td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"><?php echo $row['ten_lsp']; ?></td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"><?php echo $row['mota_lsp']; ?></td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm">
                                            <button onclick="editCategory(<?php echo $row['ma_lsp']; ?>, '<?php echo addslashes($row['ten_lsp']); ?>', '<?php echo addslashes($row['mota_lsp']); ?>')" 
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2">
                                                <i class="fas fa-edit"></i> Sửa
                                            </button>
                                            <a href="admin-loaisp.php?delete=<?php echo $row['ma_lsp']; ?>" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Không có loại sản phẩm nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editCategory(ma_lsp, ten_lsp, mota_lsp) {
            // Show edit form
            document.getElementById('edit-form').classList.remove('hidden');
            
            // Fill form with category data
            document.getElementById('edit_ma_lsp').value = ma_lsp;
            document.getElementById('edit_ten_lsp').value = ten_lsp;
            document.getElementById('edit_mota_lsp').value = mota_lsp;
            
            // Scroll to edit form
            document.getElementById('edit-form').scrollIntoView({ behavior: 'smooth' });
        }
        
        function hideEditForm() {
            document.getElementById('edit-form').classList.add('hidden');
        }
    </script>
</body>
</html>