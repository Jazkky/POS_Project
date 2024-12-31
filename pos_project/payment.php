<?php
session_start();
include 'bootstrap/headerUser.php';
include 'condb.php';

// ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    echo "<script>alert('Cart is empty!'); window.location.href='products.php';</script>";
    exit();
}

// คำนวณยอดรวมสินค้าในตะกร้า
$subtotal = 0;
$total_items = 0;
foreach($_SESSION['cart'] as $id => $item){
    $subtotal += $item['price'] * $item['quantity'];
    $total_items += $item['quantity'];
}

$vat = $subtotal * 0.07; // คำนวณ VAT 7%
$total = $subtotal + $vat;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Payment</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-body-tertiary">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h5>Payment Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price'], 2); ?>฿</td>
                                    <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?>฿</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Subtotal:</strong></p>
                                <p><strong>VAT (7%):</strong></p>
                                <p><strong>Total:</strong></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p><?php echo number_format($subtotal, 2); ?>฿</p>
                                <p><?php echo number_format($vat, 2); ?>฿</p>
                                <p><strong><?php echo number_format($total, 2); ?>฿</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <form action="process_payment.php" method="POST">
                            <button type="submit" class="btn btn-success">Confirm Payment</button>
                            <a href="products.php" class="btn btn-secondary">Back to Products</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
