
<?php
session_start(); // Make sure to start the session at the beginning
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <li class="p-2 bg-blue-700 rounded flex items-center">
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
                <h1 class="text-3xl font-semibold">Tổng quan</h1>
                
                <!-- Mobile logout button (visible on small screens) -->
                <?php if (isset($_SESSION['admin'])): ?>
                <div class="block md:hidden">
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Access check message -->
            <?php if (!isset($_SESSION['admin'])): ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                    <p>Bạn cần đăng nhập để truy cập đầy đủ tính năng quản trị.</p>
                </div>
            <?php endif; ?>
            
            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                <div class="bg-yellow-400 p-4 rounded shadow-md text-white">
                    <h2 class="text-2xl font-bold"></h2>
                    <p>Quản lý sản phẩm</p>
                    <a href="admin-product.php" class="mt-2 bg-white text-yellow-600 px-4 py-1 rounded inline-block">Xem</a>
                </div>
                <div class="bg-green-500 p-4 rounded shadow-md text-white">
                    <h2 class="text-2xl font-bold"></h2>
                    <p>Quản lý loại sản phẩm</p>
                    <a href="admin-loaisp.php" class="mt-2 bg-white text-green-600 px-4 py-1 rounded inline-block">Xem</a>
                </div>
                <div class="bg-blue-500 p-4 rounded shadow-md text-white">
                    <h2 class="text-2xl font-bold"></h2>
                    <p>Quản lý đơn hàng</p>
                    <a href="admin-order.php" class="mt-2 bg-white text-blue-600 px-4 py-1 rounded inline-block">Xem</a>
                </div>
                <div class="bg-red-500 p-4 rounded shadow-md text-white">
                    <h2 class="text-2xl font-bold"></h2>
                    <p>Quản lý nhà sản xuất</p>
                    <a href="admin-manufacturer.php" class="mt-2 bg-white text-red-600 px-4 py-1 rounded inline-block">Xem</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>