<?php
$dir = "uploads";

$files = scandir($dir);

echo "<h2>Files in Directory</h2>";

foreach ($files as $file) {
    if ($file != "." && $file != ".." &&
        is_file($dir . "/" . $file)) {
        echo htmlspecialchars($file) . "<br>";
    }
}
?>