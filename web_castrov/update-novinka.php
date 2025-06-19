<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $popis = $_POST['popis'] ?? '';
    $nadpis = $_POST['nadpis'] ?? '';
    $datum = $_POST['datum'] ?? '';
    $cesta_k_obrazku = null;

    // Zpracuj nový obrázek, pokud byl nahrán
    if (isset($_FILES['novy_obrazek']) && $_FILES['novy_obrazek']['error'] === UPLOAD_ERR_OK) {
        $nazev_souboru = time() . '-' . basename($_FILES['novy_obrazek']['name']);
        $cesta = 'uploads/' . $nazev_souboru;

        if (move_uploaded_file($_FILES['novy_obrazek']['tmp_name'], $cesta)) {
            $cesta_k_obrazku = $cesta;
        }
    }

    if ($id) {
        $sql = "UPDATE novinky SET nadpis = ?, popis = ?, datum = ?" . 
               ($cesta_k_obrazku ? ", obrazek = ?" : "") . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        if ($cesta_k_obrazku) {
            $stmt->execute([$nadpis, $popis, $datum, $cesta_k_obrazku, $id]);
        } else {
            $stmt->execute([$nadpis, $popis, $datum, $id]);
        }
    }

    header("Location: admin-panel.php");
    exit();
}
?>
