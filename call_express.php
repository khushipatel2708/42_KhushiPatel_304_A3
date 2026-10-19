<?php
$url = "http://localhost:3000/students";

$response = file_get_contents($url);

$data = json_decode($response, true);

foreach ($data as $s) {
    echo "ID: " . $s['id'] . "<br>";
    echo "Name: " . htmlspecialchars($s['name']) . "<br>";
    echo "City: " . htmlspecialchars($s['city']) . "<hr>";
}
?>