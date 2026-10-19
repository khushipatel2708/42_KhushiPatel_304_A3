<?php
include "db.php";

$id = (int)($_GET['id'] ?? 0);
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 4;
$offset = ($page - 1) * $limit;

if (isset($_GET['ajax'])) {

    $r = mysqli_query($conn,
        "SELECT * FROM products
         WHERE category_id=$id
         LIMIT $offset,$limit");

    if (mysqli_num_rows($r) == 0) {
        echo "<p class='empty'>No products found.</p>";
    }

    while ($p = mysqli_fetch_assoc($r)) {
        echo "<div class='card'>";

        if (!empty($p['picture'])) {
            echo "<img src='uploads/" .
                rawurlencode($p['picture']) .
                "' alt='Product'>";
        } else {
            echo "<p>No Image</p>";
        }

        echo "<div class='details'>";
        echo "<h3>" . htmlspecialchars($p['pname']) . "</h3>";
        echo "<p class='price'>₹" .
            htmlspecialchars($p['price']) . "</p>";
        echo "<a class='cart-btn' href='cart.php?add=" .
            (int)$p['id'] . "'>Add to Cart</a>";
        echo "</div>";

        echo "</div>";
    }

    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Our Products</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-bottom: 1px solid black;
            padding-bottom: 12px;
        }

        .header a {
            text-decoration: none;
            color: black;
            border: 1px solid black;
            padding: 8px 12px;
            margin-left: 5px;
        }

        h2 {
            text-align: center;
            margin-top: 25px;
        }

        #items {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
            margin-top: 25px;
        }

        .card {
            border: 1px solid black;
            padding: 12px;
            text-align: center;
            min-width: 0;
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
        }

        .details h3 {
            font-size: 16px;
            overflow-wrap: anywhere;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
        }

        .cart-btn {
            display: block;
            padding: 9px 5px;
            border: 1px solid black;
            color: black;
            text-decoration: none;
            margin-top: 12px;
        }

        .cart-btn:hover,
        .header a:hover,
        .pages button:hover {
            text-decoration: underline;
        }

        .pages {
            text-align: center;
            margin: 25px 0;
        }

        .pages button {
            padding: 8px 15px;
            margin: 4px;
            background: white;
            border: 1px solid black;
            cursor: pointer;
        }

        .pages button:disabled {
            font-weight: bold;
            border-width: 2px;
        }

        .empty {
            grid-column: 1 / -1;
            text-align: center;
        }

        @media (max-width: 700px) {
            #items {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 400px) {
            #items {
                grid-template-columns: 1fr;
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

    <h2>Our Products</h2>

    <div id="items">Loading products...</div>

    <div class="pages">
        <button id="p1" onclick="loadPage(1)">1</button>
        <button id="p2" onclick="loadPage(2)">2</button>
        <button id="p3" onclick="loadPage(3)">3</button>
    </div>

</div>

<script>
function loadPage(page) {
    document.getElementById("items").innerHTML =
        "Loading products...";

    fetch("products.php?id=<?= $id ?>&page=" + page + "&ajax=1")
        .then(response => response.text())
        .then(data => {
            document.getElementById("items").innerHTML = data;

            for (let i = 1; i <= 3; i++) {
                document.getElementById("p" + i).disabled =
                    (i === page);
            }
        })
        .catch(() => {
            document.getElementById("items").innerHTML =
                "Unable to load products.";
        });
}

loadPage(1);
</script>

</body>
</html>
