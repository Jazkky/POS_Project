<?php
include 'condb.php';
session_start();



$username = $_POST['username'];
$password = $_POST['password'];

$password = hash('sha512',$password);

$sql = "SELECT * FROM member WHERE username = '$username' and password = '$password'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
$status = $row['status'];

if($row > 0 ){
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['lastname'] = $row['lastname'];
    $_SESSION['role'] = $row['status'];

    if($status == '0'){
        header("Location:products.php");
    }else{
        header("Location:admin/index.php");
    }
}else{
    $_SESSION['Error'] = '<p> Your username or password invalid! </p>';
    header("Location:index.php");
}


?>