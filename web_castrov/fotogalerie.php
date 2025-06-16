<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
$obrazky = $pdo->query("SELECT * FROM galerie ORDER BY uploaded_at DESC")->fetchAll();
$celkem = count($obrazky);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Fotogalerie</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .gallery-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      justify-content: center;
      margin-top: 2rem;
    }
    .gallery-item {
      width: 200px;
      height: 220px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      padding-bottom: 10px;
      box-sizing: border-box;
      flex: 1 1 200px;
      max-width: 300px;
      text-align: center;
    }
    .gallery-item img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
      flex-shrink: 0;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .gallery-item img:hover {
      transform: scale(1.05);
    }
    .lightbox {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.8);
      align-items: center;
      justify-content: center;
    }
    .lightbox img {
      max-height: 90%;
      max-width: 90%;
      border-radius: 4px;
    }
    .lightbox:target {
      display: flex;
    }
    .lightbox-nav {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      padding: 0 2rem;
      font-size: 3rem;
      color: white;
    }
    .lightbox-nav a {
      text-decoration: none;
      color: white;
      opacity: 1;
    }
    .lightbox-nav span {
      opacity: 0.3;
    }
    .lightbox-close {
      position: absolute;
      top: 1rem;
      right: 2rem;
      font-size: 2rem;
      color: white;
      text-decoration: none;
    }
  
    .gallery-item span {
      width: 100%;
      overflow-wrap: break-word;
      white-space: normal;
      font-size: 0.9rem;
      margin-top: 5px;
    }
</style>
</head>
<body>
<div style="position:absolute; top:10px; right:20px;"><a href="admin-login.php" style="color:white;">Admin Login</a></div>
  <header>
    <h1>Fotogalerie obce Častrov</h1>
    <nav>
      <ul>
        <li><a href="index.html">Domů</a></li>
        <li><a href="kronika.php">Kronika</a></li>
        <li><a href="fotogalerie.php" class="active">Fotogalerie</a></li>
        <li><a href="kalendar.html">Kalendář akcí</a></li>
        <li><a href="kontakty.html">Kontakty</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="gallery">
      <h2 style="text-align:center;">Fotky z akcí a života obce</h2>
      <div class="gallery-grid">
        <?php foreach ($obrazky as $index => $img): ?>
          <div class="gallery-item">
            <a href="#img<?= $index ?>">
              <img src="uploads/gallery/<?= htmlspecialchars($img['filename']) ?>" alt="<?= htmlspecialchars($img['description']) ?>">
            </a>
            <p><?= htmlspecialchars($img['description']) ?></p>
          </div>

          <div id="img<?= $index ?>" class="lightbox">
            <a href="#" class="lightbox-close">&times;</a>
            <div class="lightbox-nav">
              <?php if ($index > 0): ?>
                <a href="#img<?= $index - 1 ?>">&laquo;</a>
              <?php else: ?>
                <span>&laquo;</span>
              <?php endif; ?>
              <?php if ($index < $celkem - 1): ?>
                <a href="#img<?= $index + 1 ?>">&raquo;</a>
              <?php else: ?>
                <span>&raquo;</span>
              <?php endif; ?>
            </div>
            <img src="uploads/gallery/<?= htmlspecialchars($img['filename']) ?>" alt="<?= htmlspecialchars($img['description']) ?>">
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
  <footer>
    <p>© 2025 Obec Častrov</p>
  </footer>
</body>
</html>
