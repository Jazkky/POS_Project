<?php
session_start();
include '../condb.php';


$product_name = mysqli_real_escape_string($conn,trim($_POST['product_name']));
$product_type = $_POST['product_type'];
$price = $_POST['price'];
$profile_image = $_FILES['profile_image']['name'];
$detail = $_POST['detail'];

$image_tmp = $_FILES['profile_image']['tmp_name'];
$folder = '../uploads/';
$image_location = $folder . $profile_image;


if(empty($_POST['id'])){
    $result = mysqli_query($conn , "INSERT INTO products(product_name , product_type_id, price, profile_image, detail) VALUES ('$product_name', '$product_type', $price, '$profile_image', '$detail')");
}else{
    $query_product = mysqli_query($conn , "SELECT * FROM products WHERE id = '{$_POST['id']}'");
    $dataEdit = mysqli_fetch_array($query_product);
        if(empty($profile_image)){
            $profile_image = $dataEdit['profile_image'];
        }else{
            unlink($folder . $dataEdit['profile_image']);
        }
    $result = mysqli_query($conn , "UPDATE products SET product_name = '{$product_name}', product_type_id = '{$product_type}', price = '{$price}', profile_image = '{$profile_image}', detail = '{$detail}' WHERE id = {$_POST['id']}");
}

if($result){
    move_uploaded_file($image_tmp,$image_location);
    echo "<script>alert('Success');
        window.location = 'products.php';
    </script>";
    
}else{
    echo $sql . mysqli_error($conn);
}   


?>