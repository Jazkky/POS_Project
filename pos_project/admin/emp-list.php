<?php
include '../condb.php';
include '../bootstrap/headerAdmin.php';

if(!isset($_SESSION['username'])){
    header("Location:../index.php");
}

if($_SESSION['role'] != '1'){
    header("Location:../index.php");
}


$sql = "SELECT * FROM member";
$result = mysqli_query($conn,$sql);

if(!$result){
    echo $sql . mysqli_error($conn);
}

$number = 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="mt-2 mb-2">
            <h3 class="text-center mt-4 mb-4">Employees</h3>
            <table class="table table-bordered">
                <thead>
                    <tr class="table-primary text-center">
                        <th>No.</th>
                        <th>Name</th>
                        <th>Lastname</th>
                        <th>Phone</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($result)): ?>
                    <tr>
                        <td class="text-center"><?php echo $number++ ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td>

                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>