<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location:../index.php");
}

if($_SESSION['role'] != '1'){
    header("Location:../index.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - REGISTER</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        body{
            background-image: url(../image/wallpaper.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .login-box{
            border-radius: 25px;
            padding: 5px 25px 15px 25px;
            width: 350px;
            height: 550px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100"> <!-- Flex utilities for centering -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 bg-light login-box">
                <div class="text-center mb-4 mt-5">
                    <h3 class="fw-bold">POS</h3>
                    <h6>SuperMarket</h6>
                </div>
                <form action="insert_register.php" method="post">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="lastname" class="form-control" placeholder="lastname" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="phone" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="username" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="password" required>
                    </div><br>
                    <div class="d-grid">
                        <input type="submit" value="Register" class="btn btn-success mb-3">
                    </div>
                </form>
                <a href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backspace-fill" viewBox="0 0 16 16">
  <path d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8z"/>
</svg></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>