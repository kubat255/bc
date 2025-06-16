<?php
if (!isset($_GET['id'])) {
    die("Chybí ID.");
}
$id = intval($_GET['id']);
$conn = new mysqli("localhost", "root", "", "castrov_web");
$conn->set_charset("utf8");

// Smazat obrázek (načíst cestu)
$result = $conn->query("SELECT obrazek FROM novinky WHERE id = $id");
if ($row = $result->fetch_assoc()) {
    if (file_exists($row['obrazek'])) {
        unlink($row['obrazek']);
    }
}

// Smazat záznam
$conn->query("DELETE FROM novinky WHERE id = $id");
$conn->close();
header("Location: admin-panel.php");
exit;
?>