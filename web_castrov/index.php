<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
$stmt = $pdo->query("SELECT * FROM udalosti_home ORDER BY created_at DESC");
$udalosti = $stmt-&gt;fetchAll();
?&gt;
<!DOCTYPE html>

<html lang="cs">
<head>
<meta charset="utf-8"/>
<title>Kronika obce Častrov</title>
<link href="styles.css" rel="stylesheet"/>
</head>
<body>

<header>
<div class="header-top">
<h1>Obec Častrov</h1>
<p>Oficiální webové stránky obce</p>
</div>
<nav>
<ul>
<li><a class="active" href="index.php">Domů</a></li>
<li><a href="kronika.php">Kronika</a></li>
<li><a href="fotogalerie.php">Fotogalerie</a></li>
<li><a href="kalendar.php">Kalendář akcí</a></li>
<li><a href="kontakty.php">Kontakty</a></li>
<li style="float:right;"><a href="admin-login.php">Admin Login</a></li>
</ul>
</nav>
<div class="slider">
<img alt="Obec Častrov" src="img/slider.jpg" style="width: 100%; max-height: 500px; object-fit: cover;"/>
</div>
</header>

<main class="udalosti">
<h1>Aktuality z obce</h1>
<div class="udalosti-list">
<?php foreach ($udalosti as $udalost): ?>
<div class="udalost-karta">
<img alt="Obrázek události" src="uploads/&lt;?php echo htmlspecialchars($udalost['image']); ?&gt;"/>
<h3><?php echo htmlspecialchars($udalost['title']); ?></h3>
<p><?php echo nl2br(htmlspecialchars($udalost['description'])); ?></p>
</div>
<?php endforeach; ?>
</div>
</main>
</body>
</html>
