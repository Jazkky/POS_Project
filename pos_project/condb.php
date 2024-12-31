<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database_name = "db_pos";


$conn = mysqli_connect($servername,$username,$password,$database_name);

if(!$conn){
    echo "Connect Error!";
}

?>