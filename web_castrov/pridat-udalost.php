<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: admin-login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO novinky (title, datum, popis) VALUES (?, ?, ?)");
    $stmt->execute([
      $_POST['title'],
      $_POST['datum'],
      $_POST['popis']
    ]);

    echo "✅ Událost byla úspěšně přidána.<br><a href='admin-panel.php'>Zpět do administrace</a>";
  } catch (PDOException $e) {
    echo "❌ Chyba při vkládání události: " . $e->getMessage();
  }
} else {
  echo "❗ Neplatný požadavek.";
}
?>