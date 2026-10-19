<?php
session_start();
include "db.php";

if (!isset($_SESSION['a'])) {
    $_SESSION['a'] = rand(1, 9);
    $_SESSION['b'] = rand(1, 9);
}

$msg = "";

if (isset($_POST['register'])) {

    if ((int)$_POST['captcha'] !=
        $_SESSION['a'] + $_SESSION['b']) {

        $msg = "Wrong CAPTCHA";

    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = password_hash(
            $_POST['password'],
            PASSWORD_DEFAULT
        );

        $stmt = mysqli_prepare($conn,
            "INSERT INTO users(name,email,password)
             VALUES(?,?,?)");

        mysqli_stmt_bind_param(
            $stmt, "sss", $name, $email, $pass
        );

        if (mysqli_stmt_execute($stmt)) {
            $msg = "Registration successful";
        } else {
            $msg = "Email already registered";
        }

        unset($_SESSION['a'], $_SESSION['b']);
        $_SESSION['a'] = rand(1, 9);
        $_SESSION['b'] = rand(1, 9);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>

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

        h2 {
            text-align: center;
        }

        .field {
            margin-bottom: 12px;
        }

        input {
            width: 100%;
            padding: 7px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        button {
            padding: 7px 15px;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Register</h2>

    <p><?= htmlspecialchars($msg) ?></p>

    <form method="post">

        <div class="field">
            Name:
            <input type="text" name="name" required>
        </div>

        <div class="field">
            Email:
            <input type="email" name="email" required>
        </div>

        <div class="field">
            Password:
            <input type="password" name="password" required>
        </div>

        <div class="field">
            CAPTCHA:
            <?= $_SESSION['a'] ?> + <?= $_SESSION['b'] ?> =
            <input type="number" name="captcha" required>
        </div>

        <div class="center">
            <button type="submit" name="register">
                Register
            </button>
        </div>

    </form>

    <p class="center">
        Already registered?
        <a href="login.php">Login</a>
    </p>

    <p class="center">
        <a href="index.php">Back to Home</a>
    </p>

</div>

</body>
</html>