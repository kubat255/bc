<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT nazev FROM soubory WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $soubor = $stmt->fetch();

    if ($soubor) {
        $cesta = 'uploads/' . $soubor['nazev'];
        if (file_exists($cesta)) {
            unlink($cesta);
        }
        $stmt = $pdo->prepare("DELETE FROM soubory WHERE id = ?");
        $stmt->execute([$_GET['id']]);
    }
}
header("Location: admin-panel.php");
exit;
?>
