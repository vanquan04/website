<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: loginadmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - Admin Dashboard</title>
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
                <li class="p-2 bg-blue-700 rounded flex items-center">
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
                <h1 class="text-3xl font-semibold">Quản lý sản phẩm</h1>
                
                <!-- Mobile logout button (visible on small screens) -->
                <div class="block md:hidden">
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                    </a>
                </div>
            </div>
            
            <!-- Tìm kiếm & Thêm sản phẩm -->
            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                <form method="GET" action="timkiem_sp.php" class="w-full sm:w-1/3 mb-4 sm:mb-0">
                    <div class="flex">
                        <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..." class="border rounded-l px-4 py-2 w-full">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-r transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition-colors w-full sm:w-auto" onclick="window.location.href='Themmoi_sp.php'">
                    <i class="fas fa-plus mr-2"></i> Thêm sản phẩm
                </button>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="mt-6">
                <h2 class="text-2xl font-bold mb-4">Danh sách sản phẩm</h2>
                <div class="bg-white shadow rounded overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Mã SP</th>
                                <th class="py-3 px-4 text-left">Tên sản phẩm</th>
                                <th class="py-3 px-4 text-left">Hình ảnh</th>
                                <th class="py-3 px-4 text-left">Giá</th>
                                <th class="py-3 px-4 text-left">Số lượng</th>
                                <th class="py-3 px-4 text-left">Loại SP</th>
                                <th class="py-3 px-4 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection
                            $conn = mysqli_connect("localhost", "root", "", "webbanhang");
                            if (!$conn) {
                                die("Kết nối thất bại: " . mysqli_connect_error());
                            }
                            mysqli_set_charset($conn, "utf8");
                            
                          // Fetch products
                          $query = "SELECT sp.*, lsp.ten_lsp 
                          FROM sanpham sp
                          LEFT JOIN loaisanpham lsp ON sp.ma_lsp = lsp.ma_lsp
                          ORDER BY sp.ma_sp DESC";
                 $result = mysqli_query($conn, $query);
                 
                 if (mysqli_num_rows($result) > 0) {
                     while ($row = mysqli_fetch_assoc($result)) {
                         ?>
                         <tr>
                             <td class="py-3 px-4"><?php echo $row['ma_sp']; ?></td>
                             <td class="py-3 px-4"><?php echo $row['ten_sp']; ?></td>
                             <td class="py-3 px-4">
                                 <?php
                                 // Get product image
                                 $img_query = "SELECT tentaptin_hsp FROM hinhsanpham WHERE ma_sp = " . $row['ma_sp'] . " LIMIT 1";
                                 $img_result = mysqli_query($conn, $img_query);
                                 if (mysqli_num_rows($img_result) > 0) {
                                     $img_row = mysqli_fetch_assoc($img_result);
                                     echo '<img src="uploads/products/' . $img_row['tentaptin_hsp'] . '" alt="' . $row['ten_sp'] . '" class="w-16 h-16 object-cover">';
                                 } else {
                                     // Display link_image from sanpham table if no image in hinhsanpham
                                     if (!empty($row['link_image'])) {
                                         echo '<img src="' . $row['link_image'] . '" alt="' . $row['ten_sp'] . '" class="w-16 h-16 object-cover">';
                                     } else {
                                         echo '<span class="text-gray-500">Không có hình</span>';
                                     }
                                 }
                                 ?>
                             </td>
                             <td class="py-3 px-4"><?php echo number_format($row['gia_sp'], 0, ',', '.') . ' đ'; ?></td>
                             <td class="py-3 px-4"><?php echo $row['soluong_sp']; ?></td>
                             <td class="py-3 px-4"><?php echo $row['ten_lsp']; ?></td>
                             <td class="py-3 px-4 text-center">
                                 <div class="flex justify-center space-x-2">
                                    <a href="sua_sp.php?id=<?php echo $row['ma_sp']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded">
                                         <i class="fas fa-edit"></i>
                                     </a>
                                     <a href="xoa_sp.php?ma_sp=<?php echo $row['ma_sp']; ?>" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                         <i class="fas fa-trash-alt"></i>
                                     </a>
                                   
                                 </div>
                             </td>
                         </tr>
                         <?php
                     }
                 } else {
                     ?>
                     <tr>
                         <td colspan="7" class="py-4 px-4 text-center">Không có sản phẩm nào.</td>
                     </tr>
                     <?php
                 }
                 
                 // Close connection
                 mysqli_close($conn);
                 ?>
             </tbody>
         </table>
     </div>
 </div>
</div>
</div>

<!-- JavaScript for actions -->
<script>
// Toggle mobile menu
function toggleMobileMenu() {
 const sidebar = document.querySelector('.sidebar');
 sidebar.classList.toggle('hidden');
}

// Confirm delete action
function confirmDelete(productId) {
 if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
     window.location.href = 'Xoa_sp.php?ma_sp=' + productId;
 }
}
</script>
</body>
</html>