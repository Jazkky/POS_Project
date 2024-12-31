<?php
session_start();
include 'bootstrap/headerUser.php';
include 'condb.php';

if(!isset($_SESSION['username'])){
    header("Location:index.php");
    exit();
}

if($_SESSION['role'] != '0'){
    header('location:index.php');
    exit();
}

// คำนวณค่าตะกร้าสินค้า
$subtotal = 0;
$total_items = 0;
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $id => $item){
        $subtotal += $item['price'] * $item['quantity'];
        $total_items += $item['quantity'];
    }
}

$vat = $subtotal * 0.07; // คำนวณ VAT 7%
$total = $subtotal + $vat;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-body-tertiary">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="mt-4">Order Summary</h2>
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
                        <?php if(!empty($_SESSION['cart'])): ?>
                            <?php foreach($_SESSION['cart'] as $id => $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['price'], 2); ?>฿</td>
                            <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?>฿</td>
                        </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No items in cart</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <a href="javascript:history.back()" class="btn btn-secondary">Back</a> 
            </div>
            <div class="col-lg-4">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <p>Subtotal: <?php echo number_format($subtotal, 2); ?>฿</p>
                        <p>VAT (7%): <?php echo number_format($vat, 2); ?>฿</p>
                        <h4 class="fw-bold">Total: <?php echo number_format($total, 2); ?>฿</h4>
                    </div>
                    <div class="card-footer">
                        <a href="payment.php" class="btn btn-success btn-block">Proceed to Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
