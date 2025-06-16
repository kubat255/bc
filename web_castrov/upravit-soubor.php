<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: admin-login.php');
  exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $nazev = $_POST['nazev'];

  // Změna názvu
  $stmt = $pdo->prepare("UPDATE soubory SET nazev = ? WHERE id = ?");
  $stmt->execute([$nazev, $id]);

  // Nahrazení souboru
  if (!empty($_FILES['novy_soubor']['name'])) {
    $upload_dir = 'uploads/';
    $soubor_tmp = $_FILES['novy_soubor']['tmp_name'];
    $soubor_nazev = basename($_FILES['novy_soubor']['name']);
    $soubor_cesta = $upload_dir . time() . '_' . $soubor_nazev;

    if (move_uploaded_file($soubor_tmp, $soubor_cesta)) {
      // získej starou cestu a smaž starý soubor
      $old = $pdo->prepare("SELECT cesta FROM soubory WHERE id = ?");
      $old->execute([$id]);
      $old_path = $old->fetchColumn();
      if (file_exists($old_path)) {
        unlink($old_path);
      }
      $upd = $pdo->prepare("UPDATE soubory SET cesta = ? WHERE id = ?");
      $upd->execute([$soubor_cesta, $id]);
    }
  }

  header('Location: admin-panel.php');
  exit();
}

if (!isset($_GET['id'])) {
  echo "Chybějící ID souboru.";
  exit();
}

$stmt = $pdo->prepare("SELECT * FROM soubory WHERE id = ?");
$stmt->execute([$_GET['id']]);
$soubor = $stmt->fetch();

if (!$soubor) {
  echo "Soubor nenalezen.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Upravit soubor</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<main>
  <h2>Upravit soubor</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $soubor['id'] ?>">
    <input type="text" name="nazev" value="<?= htmlspecialchars($soubor['nazev']) ?>" required><br>
    <label>Nový soubor (volitelné): <input type="file" name="novy_soubor"></label><br>
    <button type="submit">Uložit změny</button>
    <a href="admin-panel.php">Zpět</a>
  </form>
</main>
</body>
</html>
