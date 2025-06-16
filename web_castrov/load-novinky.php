<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = $pdo->query("SELECT nadpis, popis, obrazek, datum FROM novinky ORDER BY datum DESC")->fetchAll(PDO::FETCH_ASSOC);

  header('Content-Type: application/json');
  echo json_encode($data);
} catch (PDOException $e) {
  echo json_encode(['error' => $e->getMessage()]);
}
?>