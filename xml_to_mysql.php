<?php
include "db.php";

$xml = simplexml_load_file("students.xml");

foreach ($xml->student as $s) {
    $id = (int)$s->id;
    $name = (string)$s->name;
    $city = (string)$s->city;

    $stmt = mysqli_prepare($conn,
        "INSERT INTO students(id,name,city) VALUES(?,?,?)");

    mysqli_stmt_bind_param($stmt, "iss", $id, $name, $city);

    if (mysqli_stmt_execute($stmt)) {
        echo "$name inserted successfully<br>";
    } else {
        echo "Error inserting $name<br>";
    }
}
?>