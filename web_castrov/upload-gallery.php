<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');

$targetDir = "uploads/gallery/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $fileName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $desc = $_POST["description"] ?? '';
        $stmt = $pdo->prepare("INSERT INTO galerie (filename, description) VALUES (?, ?)");
        $stmt->execute([$fileName, $desc]);
        header("Location: admin-panel.php?upload=success");
        exit;
    } else {
        echo "Chyba při nahrávání souboru.";
    }
}
?>
