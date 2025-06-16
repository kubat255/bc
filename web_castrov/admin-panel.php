<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: admin-login.php');
  exit();
}
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
$udalosti = $pdo->query("SELECT * FROM udalosti ORDER BY datum DESC")->fetchAll();
$soubory = $pdo->query("SELECT * FROM soubory ORDER BY uploaded_at DESC")->fetchAll();
$kronika = $pdo->query("SELECT * FROM kronika ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Administrace | Častrov</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<main>
  <h2>Administrace obce Častrov</h2>
  <p>Přihlášen jako <strong><?= $_SESSION['admin'] ?></strong> | <a href="logout.php">Odhlásit se</a></p>

  <section>
    
  </section>

  <section>
    <h3>Nahrát soubor ke stažení</h3>
    <form method="post" action="upload.php" enctype="multipart/form-data">
      <input type="text" name="nazev" placeholder="Název souboru" required>
      <input type="file" name="soubor" required>
      <button type="submit">Nahrát</button>
    </form>
  </section>

  <section>
    <h3>Záznamy kroniky</h3>
    <ul>
      <?php foreach ($kronika as $zaznam): ?>
        <li><strong><?= htmlspecialchars($zaznam['nazev']) ?></strong> – <a href="<?= $zaznam['soubor'] ?>" target="_blank">Zobrazit</a></li>
      <?php endforeach; ?>
    </ul>
  </section>

  <section>
    <h3>Soubory ke stažení</h3>
    <ul>
      <?php foreach ($soubory as $s): ?>
        <li>
          <strong><?= htmlspecialchars($s['nazev']) ?></strong> –
          <a href="<?= $s['cesta'] ?>" target="_blank">Zobrazit</a> |
          <a href="<?= $s['cesta'] ?>" download>Stáhnout</a> |
          <a href="upravit-soubor.php?id=<?= $s['id'] ?>">Upravit</a> |
          <a href="smazat-soubor.php?id=<?= $s['id'] ?>" onclick="return confirm('Opravdu smazat tento soubor?')">Smazat</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <section>
    <ul>
      <?php foreach ($udalosti as $u): ?>
        <li>
          <strong><?= $u['datum'] ?></strong>: <?= htmlspecialchars($u['title']) ?> |
          <a href="upravit-udalost.php?id=<?= $u['id'] ?>">Upravit</a> |
          <a href="smazat-udalost.php?id=<?= $u['id'] ?>" onclick="return confirm('Opravdu smazat tuto událost?')">Smazat</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

<section>
  <h2>Přidat obrázek do fotogalerie</h2>
  <form action="upload-gallery.php" method="post" enctype="multipart/form-data">
    <label for="image">Vyberte obrázek:</label>
    <input type="file" name="image" id="image" accept="image/*" required><br>
    <label for="description">Popis:</label>
    <input type="text" name="description" id="description"><br>
    <button type="submit">Nahrát obrázek</button>
  </form>
</section>



<section>
  <h2>Správa obrázků ve fotogalerii</h2>
  <table border="1" cellspacing="0" cellpadding="8">
    <tr><th>Obrázek</th><th>Popis</th><th>Akce</th></tr>
    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
    $obrazky = $pdo->query("SELECT * FROM galerie ORDER BY uploaded_at DESC")->fetchAll();
    foreach ($obrazky as $img):
    ?>
      <tr>
        <td><img src="uploads/gallery/<?= htmlspecialchars($img['filename']) ?>" width="100"></td>
        <td>
          <form method="post" action="update-gallery-description.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $img['id'] ?>">
            <input type="text" name="description" value="<?= htmlspecialchars($img['description']) ?>" style="width: 250px;"><br>
            <input type="file" name="new_image" accept="image/*">
        </td>
        <td>
            <button type="submit">Uložit</button>
          </form>
          <form method="post" action="delete-gallery-image.php" onsubmit="return confirm('Opravdu chcete tento obrázek smazat?');">
            <input type="hidden" name="id" value="<?= $img['id'] ?>">
            <button type="submit" style="margin-top: 5px;">Smazat</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</section>


  

  <section>
    
<h3>Přidat novinku</h3>
<form action="pridat-novinku.php" method="post" enctype="multipart/form-data">
    <label>Nadpis:</label><br>
    <input type="text" name="nadpis" required><br>
    <label>Popis:</label><br>
    <textarea name="popis" required></textarea><br>
    <label>Obrázek:</label>
    <input type="file" name="obrazek" accept="image/*"><br>
    <label>Datum události:</label><br>
    <input type="datetime-local" name="datum" required>"><br>
    <input type="submit" value="Přidat novinku">
</form>

<h3>Seznam novinek</h3>
<div id="novinky">
<?php
$novinky = $pdo->query("SELECT * FROM novinky ORDER BY datum DESC")->fetchAll();
echo "<ul>";
foreach ($novinky as $n) {
    echo "<li><strong>" . htmlspecialchars($n['nadpis']) . "</strong> – " . date('d.m.Y', strtotime($n['datum'])) . "</li>";
}
echo "</ul>";
?>


</div>

<h3>Správa novinek</h3>
    <table border="1" cellspacing="0" cellpadding="5">
      <tr>
        <th>Obrázek</th>
        <th>Nadpis</th>
        <th>Popis</th>
        <th>Datum</th><th>Nový obrázek</th>
        <th>Akce</th>
      </tr>
      <?php
      $novinky = $pdo->query("SELECT * FROM novinky ORDER BY id DESC")->fetchAll();
      foreach ($novinky as $n):
      ?>
      <tr>
        <td><img src="<?= htmlspecialchars($n['obrazek']) ?>" width="100"></td>
        <form method="post" action="upravit-novinku.php" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $n['id'] ?>">
          <td><input type="text" name="nadpis" value="<?= htmlspecialchars($n['nadpis']) ?>"></td>
          <td><textarea name="popis" rows="3" cols="30"><?= htmlspecialchars($n['popis']) ?></textarea></td>
          <td><input type="datetime-local" name="datum" value="<?= date('Y-m-d\TH:i', strtotime($n['datum'])) ?>"></td>
          <td><input type="file" name="novy_obrazek"></td>
          <td>
            <input type="submit" value="Uložit"><br>
            <a href="smazat-novinku.php?id=<?= $n['id'] ?>" onclick="return confirm('Opravdu smazat tuto novinku?')">Smazat</a>
          </td>
        </form>
      </tr>
      <?php endforeach; ?>
    </table>
  </section>

</main>
</body>
</html>


