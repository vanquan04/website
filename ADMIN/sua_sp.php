<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: loginadmin.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "webbanhang");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin-products.php?error=invalid_id");
    exit();
}

$ma_sp = $_GET['id'];

// Get product details
$query = "SELECT * FROM sanpham WHERE ma_sp = $ma_sp";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: admin-products.php?error=not_found");
    exit();
}

$product = mysqli_fetch_assoc($result);

// Get product images
$img_query = "SELECT * FROM hinhsanpham WHERE ma_sp = $ma_sp";
$img_result = mysqli_query($conn, $img_query);
$images = [];
while ($img = mysqli_fetch_assoc($img_result)) {
    $images[] = $img;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_sp = $_POST['ten_sp'];
    $gia_sp = $_POST['gia_sp'];
    $giacu_sp = $_POST['giacu_sp'];
    $mota_ngan = $_POST['mota_ngan'];
    $mota_chitiet = $_POST['mota_chitiet'];
    $soluong = $_POST['soluong'];
    $ma_lsp = $_POST['ma_lsp'];
    $ma_nsx = $_POST['ma_nsx'];
    $ma_km = $_POST['ma_km'];
    $link_image = $_POST['link_image'];
    
    // Current date and time
    $ngaycapnhat = date("Y-m-d H:i:s");
    
    // Update product in database
    $update_query = "UPDATE sanpham SET 
                    ten_sp = '$ten_sp', 
                    gia_sp = '$gia_sp', 
                    giacu_sp = '$giacu_sp', 
                    mota_ngan_sp = '$mota_ngan', 
                    mota_chitiet_sp = '$mota_chitiet', 
                    ngaycapnhat_sp = '$ngaycapnhat', 
                    soluong_sp = $soluong, 
                    ma_lsp = $ma_lsp, 
                    ma_nsx = $ma_nsx, 
                    ma_km = $ma_km";
    
    // Only update link_image if provided
    if (!empty($link_image)) {
        $update_query .= ", link_image = '$link_image'";
    }
    
    $update_query .= " WHERE ma_sp = $ma_sp";
    
    if (mysqli_query($conn, $update_query)) {
        // Handle image upload
        if (isset($_FILES['hinh_sp']) && $_FILES['hinh_sp']['error'] == 0) {
            $target_dir = "uploads/products/";
            // Create directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $filename = basename($_FILES["hinh_sp"]["name"]);
            $target_file = $target_dir . $filename;
            
            // Check if file is an actual image
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (getimagesize($_FILES["hinh_sp"]["tmp_name"])) {
                // Upload file
                if (move_uploaded_file($_FILES["hinh_sp"]["tmp_name"], $target_file)) {
                    // Save image info to database
                    $img_query = "INSERT INTO hinhsanpham (tentaptin_hsp, ma_sp) VALUES ('$filename', $ma_sp)";
                    mysqli_query($conn, $img_query);
                }
            }
        }
        
        // Redirect back to product management page
        header("Location: admin-product.php?success=updated");
        exit();
    } else {
        $error = "Lỗi: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm - Admin Dashboard</title>
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
                <h1 class="text-3xl font-semibold">Sửa sản phẩm</h1>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>
            
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2">Tên sản phẩm</label>
                            <input type="text" name="ten_sp" value="<?php echo htmlspecialchars($product['ten_sp']); ?>" required class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Giá sản phẩm (VNĐ)</label>
                            <input type="number" name="gia_sp" value="<?php echo $product['gia_sp']; ?>" required class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Giá cũ (nếu có)</label>
                            <input type="number" name="giacu_sp" value="<?php echo $product['giacu_sp']; ?>" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Link hình ảnh</label>
                            <input type="text" name="link_image" value="<?php echo htmlspecialchars($product['link_image']); ?>" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <!-- Current product image -->
                        <div>
                            <label class="block text-gray-700 mb-2">Hình ảnh hiện tại</label>
                            <div class="border rounded p-2">
                                <?php if (!empty($product['link_image'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['link_image']); ?>" alt="<?php echo htmlspecialchars($product['ten_sp']); ?>" class="h-40 object-contain">
                                <?php else: ?>
                                    <p class="text-gray-500">Không có hình ảnh</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Tải lên hình ảnh mới</label>
                            <input type="file" name="hinh_sp" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Số lượng</label>
                            <input type="number" name="soluong" value="<?php echo $product['soluong_sp']; ?>" required class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Loại sản phẩm</label>
                            <select name="ma_lsp" required class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                            <?php
                            $query_lsp = "SELECT * FROM loaisanpham";
                            $result_lsp = mysqli_query($conn, $query_lsp);
                            while ($row_lsp = mysqli_fetch_assoc($result_lsp)) {
                                $selected = ($row_lsp['ma_lsp'] == $product['ma_lsp']) ? 'selected' : '';
                                echo "<option value='" . $row_lsp['ma_lsp'] . "' $selected>" . $row_lsp['ten_lsp'] . "</option>";
                            }
                            ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Nhà sản xuất</label>
                            <select name="ma_nsx" required class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                            <?php
                            $query_nsx = "SELECT * FROM nhasanxuat";
                            $result_nsx = mysqli_query($conn, $query_nsx);
                            while ($row_nsx = mysqli_fetch_assoc($result_nsx)) {
                                $selected = ($row_nsx['ma_nxs'] == $product['ma_nsx']) ? 'selected' : '';
                                echo "<option value='" . $row_nsx['ma_nxs'] . "' $selected>" . $row_nsx['ten_nxs'] . "</option>";
                            }
                            ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Khuyến mãi</label>
                            <select name="ma_km" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="0" <?php echo ($product['ma_km'] == 0) ? 'selected' : ''; ?>>Không áp dụng khuyến mãi</option>
                            <?php
                            $query_km = "SELECT * FROM khuyenmai";
                            $result_km = mysqli_query($conn, $query_km);
                            while ($row_km = mysqli_fetch_assoc($result_km)) {
                                $selected = ($row_km['ma_km'] == $product['ma_km']) ? 'selected' : '';
                                echo "<option value='" . $row_km['ma_km'] . "' $selected>" . $row_km['ten_km'] . "</option>";
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    
                   <!-- Additional product images -->


<div class="mt-6">
    <label class="block text-gray-700 mb-2">Mô tả ngắn</label>
    <textarea name="mota_ngan" rows="3" required class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"><?php echo htmlspecialchars($product['mota_ngan_sp']); ?></textarea>
</div>

<div class="mt-6">
    <label class="block text-gray-700 mb-2">Mô tả chi tiết</label>
    <textarea name="mota_chitiet" rows="6" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500"><?php echo htmlspecialchars($product['mota_chitiet_sp']); ?></textarea>
</div>

<div class="mt-6 flex justify-between">
    <a href="admin-product.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Quay lại
    </a>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition-colors">
        <i class="fas fa-save mr-2"></i> Lưu sản phẩm
    </button>
</div>
</form>
</div>
</div>
</div>
</body>
</html>