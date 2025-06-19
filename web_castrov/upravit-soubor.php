<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['popis'])) {
    $stmt = $pdo->prepare("UPDATE soubory SET popis = ? WHERE id = ?");
    $stmt->execute([$_POST['popis'], $_POST['id']]);
}
header("Location: admin-panel.php");
exit;
?>
