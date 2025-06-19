<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $soubor = $_FILES['pdf'];
    $cilova_cesta = 'uploads/' . basename($soubor['name']);

    if (move_uploaded_file($soubor['tmp_name'], $cilova_cesta)) {
        $stmt = $pdo->prepare("INSERT INTO soubory (nazev) VALUES (?)");
        $stmt->execute([basename($soubor['name'])]);
        echo "Soubor úspěšně nahrán.";
    } else {
        echo "Chyba při nahrávání souboru.";
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="pdf" accept=".pdf" required>
    <button type="submit">Nahrát PDF</button>
</form>
