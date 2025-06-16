<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: admin-login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['soubor'])) {
  try {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir);
    }

    $filename = basename($_FILES['soubor']['name']);
    $targetPath = $uploadDir . time() . '-' . $filename;

    $allowed = ['pdf', 'doc', 'docx', 'txt'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
      throw new Exception("Nepovolený typ souboru: $ext");
    }

    if (move_uploaded_file($_FILES['soubor']['tmp_name'], $targetPath)) {
      $pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("INSERT INTO soubory (nazev, cesta) VALUES (?, ?)");
      $stmt->execute([
        $_POST['nazev'],
        $targetPath
      ]);

      echo "✅ Soubor byl úspěšně nahrán a uložen do databáze.<br><a href='admin-panel.php'>Zpět do administrace</a>";
    } else {
      throw new Exception("Nepodařilo se přesunout nahraný soubor na cílové místo.");
    }
  } catch (Exception $e) {
    echo "❌ Chyba: " . $e->getMessage();
  }
} else {
  echo "❗ Neplatný požadavek nebo chybějící soubor.";
}
?>