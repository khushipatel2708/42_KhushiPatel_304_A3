<?php

$conn = mysqli_connect(
    "127.0.0.1",
    "root",
    "",
    "shopping",
    3307
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// echo "Database connected successfully";

?>