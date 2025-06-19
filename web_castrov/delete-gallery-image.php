<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("SELECT filename FROM galerie WHERE id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetchColumn();

    if ($file && file_exists("uploads/gallery/" . $file)) {
        unlink("uploads/gallery/" . $file);
    }

    $del = $pdo->prepare("DELETE FROM galerie WHERE id = ?");
    $del->execute([$id]);
}
header("Location: admin-panel.php");
exit;
?>
