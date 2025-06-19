<?php
session_start();
if (isset($_SESSION['admin'])) {
  header('Location: admin-panel.php');
  exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
  $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch();
  if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['admin'] = $user['username'];
    header('Location: admin-panel.php');
    exit();
  } else {
    $error = 'Neplatné jméno nebo heslo';
  }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Přihlášení admina</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main>
    <h2>Přihlášení do administrace</h2>
    <?php if ($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Uživatelské jméno" required><br><br>
      <input type="password" name="password" placeholder="Heslo" required><br><br>
      <button type="submit">Přihlásit se</button>
    </form>
  </main>
</body>
</html>
