<?php
session_start();
include '../condb.php';

if(!empty($_GET['id'])){
    $query_product = mysqli_query($conn , "SELECT * FROM products WHERE id = '{$_GET['id']}'");
    $dataEdit = mysqli_fetch_array($query_product);
    @unlink('../uploads/' . $dataEdit['profile_image']);
    $result = mysqli_query($conn, "DELETE FROM products WHERE id = '{$_GET['id']}'");

    if($result){
        echo "<script>alert('delete Success');
        window.location = 'products.php';
        </script>";
    }else{
        echo $sql. mysqli_error($conn);
    }
}





?>