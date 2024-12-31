<?php
session_start();
include '../condb.php';

if (!isset($_SESSION['username'])) {
    header("Location:../index.php");
}

if ($_SESSION['role'] != '1') {
    header("Location:../index.php");
}


$sql = "SELECT id , type_name FROM product_type";
$result = mysqli_query($conn, $sql);
$sql2 = "SELECT products.*,product_type.type_name FROM products INNER JOIN product_type ON products.product_type_id = product_type.id";
$result2 = mysqli_query($conn, $sql2);
$count = mysqli_num_rows($result2);

$dataEdit = [
    'id' => '',
    'product_name' => '',
    'product_type_id' => '',
    'price' => '',
    'detail' => '',
];

if (!empty($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id = '{$_GET['id']}'");
    $row_product = mysqli_num_rows($query_product);

    if ($row_product == 0) {
        header('location:products.php');
    }
    $dataEdit = mysqli_fetch_array($query_product);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Products</title>
    <?php include '../bootstrap/headerAdmin.php'; ?>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-body-tertiary">
    <div class="container" style="margin-top: 35px">
        <h4 class="fw-bold mb-4">Mange - Product</h4>
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="product-form.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $dataEdit['id'] ?>">
                    <div class="row g-3 mb-3">

                        <div class="col-sm-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo $dataEdit['product_name'] ?>">
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="product_type" aria-label="Default select example">
                                <option value="" selected disabled>Open this select menu</option>

                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $selected = isset($dataEdit['product_type_id']) && $row['id'] == $dataEdit['product_type_id'] ? 'selected' : '';
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['type_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option>ກະລຸນາເລືອກປະເພດສິນຄ້າ</option>";
                                }

                                ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $dataEdit['price'] ?>">
                        </div>

                        <div class="col-sm-6">
                            <?php if (!empty($dataEdit['profile_image'])): ?>
                                <div>
                                    <img src="../uploads/<?php echo $dataEdit['profile_image'] ?>" alt="product" width="100">
                                </div>
                            <?php endif; ?>
                            <label for="formFile" class="form-label">Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/jpg, image/png ,image/jpeg">
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label">Details</label>
                            <textarea name="detail" class="form-control" rows="3"><?php echo $dataEdit['detail'] ?></textarea>
                        </div>
                    </div>
                    <?php if (empty($dataEdit['id'])): ?>
                        <button type="submit" class="btn btn-primary">Create</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary">Update</button>
                    <?php endif; ?>
                </form>
            </div>
            <hr class="py-5">
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered border-info">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Product Name</th>
                            <th>Type</th>
                            <th style="width: 150px;">Price</th>
                            <th style="width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($count > 0): ?>
                            <?php while ($row = mysqli_fetch_array($result2)) : ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($row['profile_image'])): ?>
                                            <img src="../uploads/<?php echo $row['profile_image'] ?>" alt="product" width="100">
                                        <?php else: ?>
                                            <img src="../bootstrap/images/no-image.png" alt="product" width="100">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['product_name'] ?>
                                        <div>
                                            <small class="text-muted"><?php echo nl2br($row['detail']); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $row['type_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['price'] ?>
                                    </td>
                                    <td>
                                        <a href="products.php?id=<?php echo $row['id'] ?>" class="btn btn-warning" role="button">Edit</a>
                                        <a onclick="return confirm('Do you want Delete');" href="product_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" role="button">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-danger">
                                    <h4>Product not found</h4>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>