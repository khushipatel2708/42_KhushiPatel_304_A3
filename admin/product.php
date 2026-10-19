<?php
session_start();
include "../db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $price = (float)$_POST['price'];
    $cat = (int)$_POST['category'];

    $file = $_FILES['pic']['tmp_name'];
    $info = getimagesize($file);

    if ($info && in_array($info['mime'],
        ['image/jpeg', 'image/png'])) {

        $src = $info['mime'] == 'image/png'
            ? imagecreatefrompng($file)
            : imagecreatefromjpeg($file);

        $w = imagesx($src);
        $h = imagesy($src);
        $nw = 200;
        $nh = (int)($h * $nw / $w);

        $img = imagecreatetruecolor($nw, $nh);
        imagecopyresampled(
            $img, $src, 0, 0, 0, 0, $nw, $nh, $w, $h
        );

        $filename = uniqid() . ".jpg";
        imagejpeg($img, "../uploads/" . $filename, 80);

        imagedestroy($src);
        imagedestroy($img);

        mysqli_query($conn,
            "INSERT INTO products(category_id,pname,price,picture)
             VALUES($cat,'$name',$price,'$filename')");

        echo "Product added";
    } else {
        echo "Upload a valid JPG or PNG image";
    }
}

$c = mysqli_query($conn, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>

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
        }

        input, select {
            width: 100%;
            padding: 7px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 8px 15px;
            margin-top: 15px;
        }

        .center {
            text-align: center;
        }

        .field {
            margin-bottom: 12px;
        }

        a {
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>

<body>

<div class="box">

    <h3 class="center">Add Product</h3>


    <form method="post" enctype="multipart/form-data">

        <div class="field">
            Product Name:
            <input type="text" name="pname" required>
        </div>

        <div class="field">
            Price:
            <input type="number" step="0.01"
                   name="price" min="0" required>
        </div>

        <div class="field">
            Category:
            <select name="category" required>
                <?php while ($x = mysqli_fetch_assoc($c)) { ?>
                    <option value="<?= $x['id'] ?>">
                        <?= htmlspecialchars($x['name']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            Picture:
            <input type="file" name="pic"
                   accept=".jpg,.jpeg,.png" required>
        </div>

        <div class="center">
            <button type="submit" name="add">
                Add Product
            </button>
        </div>

    </form>

    <div class="center">
        <a href="category.php">Manage Categories</a>
        <br>
        <a href="logout.php">Logout</a>
    </div>

</div>

</body>
</html>