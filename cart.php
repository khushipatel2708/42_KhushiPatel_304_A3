<?php
session_start();
include "db.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];

    $check = mysqli_query($conn,
        "SELECT id FROM products WHERE id=$id");

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['cart'][$id] =
            ($_SESSION['cart'][$id] ?? 0) + 1;
    }

    header("Location: cart.php");
    exit;
}

if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$id]);

    header("Location: cart.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid black;
            padding-bottom: 12px;
            flex-wrap: wrap;
        }

        .header a {
            color: black;
            text-decoration: none;
            border: 1px solid black;
            padding: 8px 12px;
            margin-left: 5px;
        }

        h2 {
            text-align: center;
        }

        .item {
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid black;
            padding: 12px;
            margin: 15px 0;
        }

        .item img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .details {
            flex: 1;
            overflow-wrap: anywhere;
        }

        .details p {
            margin: 8px 0;
        }

        .remove {
            color: black;
            border: 1px solid black;
            padding: 7px 10px;
            text-decoration: none;
            display: inline-block;
        }

        .total {
            border: 1px solid black;
            padding: 15px;
            text-align: right;
            margin-top: 20px;
        }

        .empty {
            text-align: center;
            border: 1px solid black;
            padding: 25px;
            margin-top: 20px;
        }

        .center {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            color: black;
            border: 1px solid black;
            padding: 10px 15px;
            text-decoration: none;
            margin: 5px;
        }

        @media (max-width: 500px) {
            .item {
                align-items: flex-start;
                gap: 10px;
            }

            .item img {
                width: 75px;
                height: 75px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2>Shopping Website</h2>

        <div>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
        </div>
    </div>

    <h2>My Shopping Cart</h2>

    <?php
    foreach ($_SESSION['cart'] as $id => $qty) {

        $id = (int)$id;

        $r = mysqli_query($conn,
            "SELECT * FROM products WHERE id=$id");

        $p = mysqli_fetch_assoc($r);

        if ($p) {
            $subtotal = $p['price'] * $qty;
            $total += $subtotal;
    ?>

        <div class="item">

            <?php if (!empty($p['picture'])) { ?>
                <img
                    src="uploads/<?= rawurlencode($p['picture']) ?>"
                    alt="Product">
            <?php } else { ?>
                <div>No Image</div>
            <?php } ?>

            <div class="details">
                <h3><?= htmlspecialchars($p['pname']) ?></h3>

                <p>Price: ₹<?= number_format($p['price'], 2) ?></p>

                <p>Quantity: <?= (int)$qty ?></p>

                <p>
                    Subtotal:
                    ₹<?= number_format($subtotal, 2) ?>
                </p>

                <a class="remove"
                   href="cart.php?remove=<?= $id ?>">
                    Remove
                </a>
            </div>

        </div>

    <?php
        }
    }
    ?>

    <?php if (empty($_SESSION['cart']) || $total == 0) { ?>

        <div class="empty">
            <h3>Your cart is empty</h3>
            <p>Add some products to your shopping cart.</p>
            <a class="btn" href="index.php">Continue Shopping</a>
        </div>

    <?php } else { ?>

        <div class="total">
            <h3>Total Amount: ₹<?= number_format($total, 2) ?></h3>
        </div>

        <div class="center">
            <a class="btn" href="index.php">Continue Shopping</a>
            <a class="btn" href="checkout.php">Proceed to Checkout</a>
        </div>

    <?php } ?>

</div>

</body>
</html>