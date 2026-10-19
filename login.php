<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $r = mysqli_stmt_get_result($stmt);
    $u = mysqli_fetch_assoc($r);

    if ($u && password_verify($_POST['password'], $u['password'])) {
        $_SESSION['user'] = $u['id'];
        echo "Login successful";
        echo "<a href='index.php'>Go to Shopping</a>";
    } else {
        echo "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>

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
            width: 280px;
            padding: 20px;
            border: 1px solid black;
        }

        input {
            width: 100%;
            padding: 7px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 7px 15px;
        }

        .center {
            text-align: center;
        }

        .field {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="box">

    <h3 class="center">User Login</h3>


    <form method="post">

        <div class="field">
            Email:
            <input type="email" name="email" required>
        </div>

        <div class="field">
            Password:
            <input type="password" name="password" required>
        </div>

        <div class="center">
            <button type="submit" name="login">Login</button>
        </div>

    </form>

    <p class="center">
        Don't have an account?
        <a href="register.php">Register</a>
    </p>

    <p class="center">
        <a href="index.php">Back to Home</a>
    </p>

</div>

</body>
</html>