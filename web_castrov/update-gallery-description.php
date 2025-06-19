<?php
$pdo = new PDO('mysql:host=localhost;dbname=castrov_web;charset=utf8mb4', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['description'])) {
    $id = $_POST['id'];
    $desc = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE galerie SET description = ? WHERE id = ?");
    $stmt->execute([$desc, $id]);

    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        $old = $pdo->prepare("SELECT filename FROM galerie WHERE id = ?");
        $old->execute([$id]);
        $oldFile = $old->fetchColumn();
        if ($oldFile && file_exists("uploads/gallery/" . $oldFile)) {
            unlink("uploads/gallery/" . $oldFile);
        }

        $newName = basename($_FILES['new_image']['name']);
        move_uploaded_file($_FILES['new_image']['tmp_name'], "uploads/gallery/" . $newName);

        $upd = $pdo->prepare("UPDATE galerie SET filename = ? WHERE id = ?");
        $upd->execute([$newName, $id]);
    }
}
header("Location: admin-panel.php");
exit;
?>
