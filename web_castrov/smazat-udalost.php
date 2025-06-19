<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: admin-login.php');
  exit();
}
if (isset($_GET['id'])) {
  $pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
  $stmt = $pdo->prepare("DELETE FROM udalosti WHERE id = ?");
  $stmt->execute([$_GET['id']]);
}
header('Location: admin-panel.php');
exit();
?>
