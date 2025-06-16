<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
$soubory = $pdo->query("SELECT * FROM soubory ORDER BY uploaded_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Kronika obce Častrov</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div style="position:absolute; top:10px; right:20px;"><a href="admin-login.php" style="color:white;">Admin Login</a></div>
  <header>
    <h1>Kronika obce Častrov</h1>
    <nav>
      <ul>
        <li><a href="index.html">Domů</a></li>
        <li><a href="kronika.php" class="active">Kronika</a></li>
        <li><a href="fotogalerie.php">Fotogalerie</a></li>
        <li><a href="kalendar.html">Kalendář akcí</a></li>
        <li><a href="kontakty.html">Kontakty</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section>
      <h2>Kronika obce Častrov 1953–1980</h2>
      <iframe
        src="uploads/kronika1953.pdf"
        width="100%" height="700px"
        style="border: none; margin-top: 2rem;">
      </iframe>
      <p style="text-align: center; margin-top: 2rem;">
        <a href="uploads/kronika1953.pdf" download>Stáhnout kroniku (PDF)</a>
      </p>
    </section>
  </main>
  <footer>
    <p>© 2025 Obec Častrov</p>
  </footer>
</body>
</html>
