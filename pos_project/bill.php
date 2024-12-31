<?php
// เริ่ม session และเชื่อมต่อกับฐานข้อมูล
session_start();
include 'condb.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการส่ง order_id หรือไม่
if (!isset($_GET['order_id'])) {
    die("ไม่พบหมายเลขคำสั่งซื้อ");
}

$order_id = $_GET['order_id'];

// ดึงข้อมูล order จากตาราง orders
$order_sql = "SELECT * FROM orders WHERE id = '$order_id'";
$order_result = mysqli_query($conn, $order_sql);
$order = mysqli_fetch_assoc($order_result);

// ตรวจสอบว่ามีคำสั่งซื้อหรือไม่
if (!$order) {
    die("ไม่พบคำสั่งซื้อ");
}

// ดึงข้อมูล order detail จากตาราง order_detail
$detail_sql = "SELECT * FROM order_detail WHERE order_id = '$order_id'";
$detail_result = mysqli_query($conn, $detail_sql);

// คำนวณยอดรวมและภาษี
$subtotal = 0;
$items = [];

while ($row = mysqli_fetch_assoc($detail_result)) {
    $items[] = $row;
    $subtotal += $row['price'] * $row['quantity'];
}

$tax = $subtotal * 0.07; // สมมติว่าภาษี 7%
$total = $subtotal + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จรับเงิน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4 class="card-title">POS - Supermarket</h4>
                    <p>Laos<br>020 91799635</p>
                </div>

                <div class="mb-4">
                    <p><strong>ID:</strong> <?php echo $order['id']; ?></p>
                    <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
                    <p><strong>Employee:</strong> <?php echo $order['member_id']; ?> <!-- สามารถดึงชื่อผู้ใช้จากตาราง member ได้หากต้องการ --></p>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col" class="text-center">Qty</th>
                            <th scope="col" class="text-end">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo $item['product_name']; ?></td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end"><?php echo number_format($item['price'], 2); ?>฿</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between">
                    <p>subTotal:</p>
                    <p><?php echo number_format($subtotal, 2); ?>฿</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>VAT (7%):</p>
                    <p><?php echo number_format($tax, 2); ?>฿</p>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                    <p>Total:</p>
                    <p><?php echo number_format($total, 2); ?>฿</p>
                </div>

                <div class="text-center mt-4">
                    <p class="mb-0">*** Thankyou ***</p>
                </div>

                <div class="text-center mt-4">
                    <!-- สามารถแสดงบาร์โค้ดหรือ QR Code ได้ -->
                    <img src="path/to/barcode/image.png" alt="Barcode" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
