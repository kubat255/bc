
<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');

// Cesty
$uploadDir = __DIR__ . "/uploads/";
$uploadUrl = "uploads/";

// Formulář
$id = $_POST['id'];
$popis = $_POST['popis'];

// Najdeme původní soubor
$stmt = $pdo->prepare("SELECT nazev FROM soubory WHERE id = ?");
$stmt->execute([$id]);
$radek = $stmt->fetch();
$starySoubor = $radek ? $radek['nazev'] : null;

if (isset($_FILES['novy_soubor']) && $_FILES['novy_soubor']['error'] === UPLOAD_ERR_OK) {
    $novySoubor = $_FILES['novy_soubor'];
    $nazevSouboru = basename($novySoubor['name']);
    $cilovaCestaDisk = $uploadDir . $nazevSouboru;
    $cilovaCestaURL = $uploadUrl . $nazevSouboru;

    // Smazat starý soubor
    if ($starySoubor && file_exists($uploadDir . $starySoubor)) {
        unlink($uploadDir . $starySoubor);
    }

    // Nahrát nový
    move_uploaded_file($novySoubor['tmp_name'], $cilovaCestaDisk);

    // Zápis
    $stmt = $pdo->prepare("UPDATE soubory SET nazev = ?, popis = ? WHERE id = ?");
    $stmt->execute([$nazevSouboru, $popis, $id]);
} else {
    // Jen popis
    $stmt = $pdo->prepare("UPDATE soubory SET popis = ? WHERE id = ?");
    $stmt->execute([$popis, $id]);
}

header("Location: admin-panel.php");
exit;
?>
