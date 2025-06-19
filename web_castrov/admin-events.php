<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $imageName = '';
  if (!empty($_FILES['image']['name'])) {
    $imageName = basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $imageName);
  }
  $stmt = $pdo->prepare("INSERT INTO udalosti_home (title, description, image) VALUES (?, ?, ?)");
  $stmt->execute([$title, $description, $imageName]);
  header("Location: admin-events.php");
  exit;
}
$events = $pdo->query("SELECT * FROM udalosti_home ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Správa událostí</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Přidat novou událost</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Název události" required><br>
    <textarea name="description" placeholder="Popis události" required></textarea><br>
    <input type="file" name="image"><br>
    <button type="submit">Přidat</button>
  </form>
  <h3>Aktuální události</h3>
  <ul>
    <?php foreach ($events as $event): ?>
      <li><strong><?php echo htmlspecialchars($event['title']); ?></strong> – <?php echo htmlspecialchars($event['created_at']); ?></li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
