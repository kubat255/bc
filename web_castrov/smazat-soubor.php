<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: admin-login.php');
  exit();
}
if (isset($_GET['id'])) {
  $pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
  $stmt = $pdo->prepare("SELECT cesta FROM soubory WHERE id = ?");
  $stmt->execute([$_GET['id']]);
  $soubor = $stmt->fetch();
  if ($soubor && file_exists($soubor['cesta'])) {
    unlink($soubor['cesta']);
  }
  $stmt = $pdo->prepare("DELETE FROM soubory WHERE id = ?");
  $stmt->execute([$_GET['id']]);
}
header('Location: admin-panel.php');
exit();
?>
