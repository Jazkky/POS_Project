<?php
session_start();
include 'bootstrap/headerUser.php';
include 'condb.php';


if (!isset($_SESSION['username'])) {
    header("Location:index.php");
}

if ($_SESSION['role'] != '0') {
    header('location:index.php');
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['action']) && $_GET['action'] === 'add') {
    $product_id = $_GET['id'];
    $quantity = 1;

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $product_sql = "SELECT * FROM products WHERE id = '$product_id'";
        $product_result = mysqli_query($conn, $product_sql);
        $product = mysqli_fetch_array($product_result);


        $_SESSION['cart'][$product_id] = array(
            'name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => $quantity
        );
    }
    header("Location: products.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $product_id = $_GET['id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    header('location:products.php');
}


if (isset($_GET['action'])) {
    $product_id = $_GET['id'];

    if ($_GET['action'] == 'increase') {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
        header("Location: products.php");
        exit();
    } elseif ($_GET['action'] == 'decrease') {
        if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity'] -= 1;
            header("Location: products.php");
        exit();
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    } elseif ($_GET['action'] == 'delete') {
        unset($_SESSION['cart'][$product_id]);
    }
}

$subtotal = 0;
$total_items = 0;
foreach ($_SESSION['cart'] as $id => $item) {
    $subtotal += $item['price'] * $item['quantity'];
    $total_items += $item['quantity'];
}

$vat = $subtotal * 0.07;
$total = $vat + $subtotal;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Products</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-body-tertiary">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <div class="col-md-3 mb-4">
                            <a href="products.php?action=add&id=<?php echo $row['id'] ?>" style="text-decoration:none;">
                                <div class="card h-100 mt-5">
                                    <?php if (!empty($row['profile_image'])): ?>
                                        <img src="uploads/<?php echo $row['profile_image']; ?>" alt="product" class="card-img-top" width="100">
                                    <?php else: ?>
                                        <img src="bootstrap/images/no-image.png" alt="product" class="card-img-top" width="100">
                                    <?php endif; ?>
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo $row['product_name'] ?></h5>
                                        <p class="card-text text-success"><?php echo $row['price'] ?>฿</p>
                                        <p class="card-text text-muted"><?php echo nl2br($row['detail']) ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mt-5">
                    <div class="card-header">
                        <h5>Cart</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($_SESSION['cart'])): ?>
                                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                        <tr>
                                            <td style="width:60%; text-align:left; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                                <?php echo $item['name']; ?>
                                            </td>
                                            <td style="width:40%; text-align:center;">
                                                <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                                    <a href="products.php?action=decrease&id=<?php echo $id ?>" class="btn btn-warning btn-sm">-</a>
                                                    <span><?php echo $item['quantity']; ?></span>
                                                    <a href="products.php?action=increase&id=<?php echo $id ?>" class="btn btn-success btn-sm">+</a>
                                                    <a href="products.php?action=delete&id=<?php echo $id ?>" class="btn btn-danger btn-sm" style="margin-left:15px;">Delete</a>
                                                </div>
                                            </td>

                                            <td style="width:20%; text-align:right;"><?php echo number_format($item['price'] * $item['quantity'], 2) ?>฿</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <p>subTotal : <?php echo number_format($subtotal, 2) ?>฿</p>
                        <p>VAT 7% : <?php echo number_format($vat, 2) ?>฿</p>
                        <p class="fw-bold">Total : <?php echo number_format($total, 2) ?>฿</p>
                        <a href="checkout.php" class="btn btn-success btn-block">Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>