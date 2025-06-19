<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: admin-login.php');
  exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("UPDATE udalosti SET title = ?, datum = ?, popis = ? WHERE id = ?");
  $stmt->execute([
    $_POST['title'],
    $_POST['datum'],
    $_POST['popis'],
    $_POST['id']
  ]);
  header('Location: admin-panel.php');
  exit();
}

if (!isset($_GET['id'])) {
  echo "Chybějící ID události.";
  exit();
}

$stmt = $pdo->prepare("SELECT * FROM udalosti WHERE id = ?");
$stmt->execute([$_GET['id']]);
$udalost = $stmt->fetch();

if (!$udalost) {
  echo "Událost nenalezena.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Upravit událost</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<main>
  <h2>Upravit událost</h2>
  <form method="post">
    <input type="hidden" name="id" value="<?= $udalost['id'] ?>">
    <input type="text" name="title" value="<?= htmlspecialchars($udalost['title']) ?>" required>
    <input type="date" name="datum" value="<?= $udalost['datum'] ?>" required>
    <textarea name="popis"><?= htmlspecialchars($udalost['popis']) ?></textarea><br>
    <button type="submit">Uložit změny</button>
    <a href="admin-panel.php">Zpět</a>
  </form>
</main>
</body>
</html>
