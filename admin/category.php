<?php
session_start();
include "../db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    mysqli_query($conn,
        "INSERT INTO categories(name) VALUES('$name')");

    header("Location: category.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    mysqli_query($conn,
        "DELETE FROM products WHERE category_id=$id");

    mysqli_query($conn,
        "DELETE FROM categories WHERE id=$id");

    header("Location: category.php");
    exit;
}

$r = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>

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
            width: 350px;
            padding: 20px;
            border: 1px solid black;
        }

        input {
            padding: 8px;
            width: 65%;
        }

        button {
            padding: 8px;
        }

        .item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        a {
            margin-left: 10px;
        }

        .links {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="box">

    <h3 align="center">Manage Categories</h3>

    <form method="post">
        <input type="text" name="name"
               placeholder="Category name" required>
        <button type="submit" name="add">Add</button>
    </form>

    <hr>

    <h4>Category List</h4>

    <?php while ($row = mysqli_fetch_assoc($r)) { ?>
        <div class="item">
            <?= htmlspecialchars($row['name']) ?>

            <a href="?delete=<?= $row['id'] ?>"
               onclick="return confirm('Delete this category?')">
                Delete
            </a>
        </div>
    <?php } ?>

    <div class="links">
        <a href="product.php">Manage Products</a>
        <br><br>
        <a href="logout.php">Logout</a>
    </div>

</div>

</body>
</html>