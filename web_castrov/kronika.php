<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
$soubory = $pdo->query("SELECT * FROM soubory WHERE sekce = 'kronika' ORDER BY uploaded_at DESC")->fetchAll();
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
      <h2>Kronika obce Častrov</h2>
      
      <iframe
        id="pdf-frame"
        src="uploads/<?= htmlspecialchars($soubory[0]['nazev']) ?>"
        width="100%" height="700px"
        style="border: none; margin-top: 2rem;">
      </iframe>
      
      <h3 style="margin-top: 2rem;">Seznam kronik:</h3>
      <div id="pdf-buttons" style="margin-top: 1rem;">
        <?php foreach ($soubory as $soubor): ?>
          <div style="margin-bottom: 0.5rem;">
            <h4><?= htmlspecialchars($soubor['popis']) ?></h4>
            <button onclick="zobrazPDF('uploads/<?= htmlspecialchars($soubor['nazev']) ?>')">Zobrazit</button>
            <a href="uploads/<?= htmlspecialchars($soubor['nazev']) ?>" download>
              <button type="button">Stáhnout</button>
            </a>
          </div>
        <?php endforeach; ?>
      </div>


    </section>
  </main>
  <footer>
    <p>© 2025 Obec Častrov</p>
  </footer>
  <script>
    function zobrazPDF(cesta) {
      document.getElementById('pdf-frame').src = cesta;
    }
  </script>
</body>
</html>
