<?php
include '../condb.php';

$name = $_POST['name'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];
$username = $_POST['username'];
$password = $_POST['password'];

$password = hash('sha512',$password);

$sql = "INSERT INTO member(name,lastname,phone,username,password,status) VALUES ('$name','$lastname','$phone','$username','$password','0')";
$result = mysqli_query($conn,$sql);

if($result){
    echo "<script>alert('Insert success!');</script>";
    echo "<script>window.location ='index.php';</script>";
}else{
    echo mysqli_error($conn);
}

?>