<?php
include "db.php";

$r = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Website</title>

    <style>
        body {
            font-family: Arial;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 320px;
            padding: 20px;
            border: 1px solid black;
            text-align: center;
        }

        .category {
            display: block;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid black;
            text-decoration: none;
            color: black;
        }

        .links a {
            display: inline-block;
            margin: 5px 2px;
            padding: 7px;
            border: 1px solid black;
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Shopping Website</h2>
    <hr>

    <h3>Categories</h3>

    <?php while ($c = mysqli_fetch_assoc($r)) { ?>
        <a class="category"
           href="products.php?id=<?= $c['id'] ?>">
            <?= htmlspecialchars($c['name']) ?>
        </a>
    <?php } ?>

    <hr>

    <div class="links">
        <a href="register.php">Register</a>
        <a href="login.php">User Login</a>
        <a href="cart.php">Shopping Cart</a>
    </div>

</div>

</body>
</html>