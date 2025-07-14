<?php
include_once('connect.php');
$sql = "DELETE FROM sanpham WHERE ma_sp=" . $_GET['ma_sp'];
if (mysqli_query(($conn), $sql)) {
    echo "Sản phẩm đã được xóa thành công.";
    header("Location: admin-product.php");
} else {
    echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
?>