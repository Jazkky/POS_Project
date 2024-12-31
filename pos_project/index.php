<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - LOGIN</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        body{
            background-image: url(image/wallpaper.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .login-box{
            border-radius: 25px;
            padding: 5px 25px 15px 25px;
            width: 350px;
            height: 350px;
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
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="d-grid">
                        <input type="submit" value="Login" class="btn btn-success mb-5">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>