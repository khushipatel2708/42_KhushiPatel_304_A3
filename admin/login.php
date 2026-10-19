<?php
session_start();
include "../db.php";

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM admin WHERE username = ?");

    mysqli_stmt_bind_param($stmt, "s", $u);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $a = mysqli_fetch_assoc($result);

    if ($a && md5($p) === $a['password']) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $a['id'];

        header("Location: category.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Admin Login</title>

<style>
    body {
        font-family: Arial;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .box {
        width: 280px;
        padding: 20px;
        border: 1px solid black;
    }

    input {
        width: 95%;
        padding: 6px;
    }

    button {
        padding: 6px 15px;
    }
</style>

</head>
<body>

<div class="box">
    <h3 align="center">Admin Login</h3>

    <form method="post">
        Username:<br>
        <input type="text" name="username" required>
        <br><br>

        Password:<br>
        <input type="password" name="password" required>
        <br><br>

        <center>
            <button type="submit" name="login">Login</button>
        </center>
    </form>
</div>

</body>
</html>