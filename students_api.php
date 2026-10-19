<?php
header("Content-Type: application/json");

$students = [
    ["id" => 1, "name" => "Khushi", "city" => "Surat"],
    ["id" => 2, "name" => "Rahul", "city" => "Ahmedabad"]
];

echo json_encode($students);
?>