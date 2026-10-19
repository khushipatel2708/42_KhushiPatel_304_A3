<?php
include "db.php";

$r = mysqli_query($conn, "SELECT * FROM students");

$xml = new SimpleXMLElement("<students/>");

while ($row = mysqli_fetch_assoc($r)) {
    $s = $xml->addChild("student");

    $s->addChild("id", $row['id']);
    $s->addChild("name", htmlspecialchars($row['name']));
    $s->addChild("city", htmlspecialchars($row['city']));
}

$xml->asXML("students_output.xml");

echo "Data exported to XML successfully";
?>