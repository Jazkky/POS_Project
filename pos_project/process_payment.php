<?php
session_start();
include 'condb.php';

// เปิดการแสดงข้อผิดพลาดทั้งหมด
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Cart is empty!'); window.location.href='products.php';</script>";
    exit();
}

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['user_id'])) {
    // หากผู้ใช้ยังไม่ล็อกอิน ให้เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
    header("Location: login.php");
    exit();
}

$member_id = $_SESSION['user_id']; 

// ดึงข้อมูล member_id จาก session
$member_id = $_SESSION['user_id']; // ต้องแน่ใจว่า $_SESSION['user_id'] เก็บค่า member_id จากตาราง member

// คำนวณยอดรวมสินค้าในตะกร้า
$subtotal = 0;
$total_items = 0;
foreach ($_SESSION['cart'] as $id => $item) {
    $subtotal += $item['price'] * $item['quantity'];
    $total_items += $item['quantity'];
}

$vat = $subtotal * 0.07; // คำนวณ VAT 7%
$grand_total = $subtotal + $vat;

// บันทึกข้อมูลคำสั่งซื้อในตาราง orders
$order_sql = "INSERT INTO orders (member_id, grand_total, order_date) 
              VALUES ('$member_id', '$grand_total', NOW())";
$order_result = mysqli_query($conn, $order_sql);

// ตรวจสอบว่าการบันทึกข้อมูลในตาราง orders สำเร็จหรือไม่
if ($order_result) {
    // รับ order_id ที่เพิ่งเพิ่มเข้าไป
    $order_id = mysqli_insert_id($conn);

    // บันทึกรายละเอียดสินค้าในตาราง order_detail
    foreach ($_SESSION['cart'] as $product_id => $item) {
        // ดึงข้อมูลสินค้าจากตาราง products เพื่อให้แน่ใจว่าได้ข้อมูลที่ถูกต้อง
        $product_sql = "SELECT * FROM products WHERE id = '$product_id'";
        $product_result = mysqli_query($conn, $product_sql);
        
        if ($product_result && mysqli_num_rows($product_result) > 0) {
            $product = mysqli_fetch_array($product_result);

            $product_name = mysqli_real_escape_string($conn,$product['product_name']);
            $product_price = $product['price'];
            $product_quantity = $item['quantity'];
            $total_price = $product_price * $product_quantity;

            // บันทึกข้อมูลลงใน order_detail
            $order_details_sql = "INSERT INTO order_detail (order_id, product_id, product_name, price, quantity) 
                                  VALUES ('$order_id', '$product_id', '$product_name', '$product_price', '$product_quantity')";
            
            if (!mysqli_query($conn, $order_details_sql)) {
                echo "Error inserting into order_detail: " . mysqli_error($conn);
                exit();
            }
        } else {
            echo "Error fetching product details: " . mysqli_error($conn);
            exit();
        }
    }

    // ล้างตะกร้าสินค้า
    unset($_SESSION['cart']);

    // แสดงข้อความเมื่อชำระเงินสำเร็จ
    echo "<script>alert('Payment Successful!'); 
    window.location.href = 'bill.php?order_id=" . $order_id . "';
    </script>";
} else {
    // แสดงข้อผิดพลาดเมื่อบันทึกคำสั่งซื้อไม่สำเร็จ
    echo "Error inserting into orders: " . mysqli_error($conn);
    exit();
}
?>
