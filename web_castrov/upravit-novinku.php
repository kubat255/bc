<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nadpis = $_POST['nadpis'];
    $popis = $_POST['popis'];
    $datum = $_POST['datum'];

    // Aktualizace textových dat
    $sql = "UPDATE novinky SET nadpis = ?, popis = ?, datum = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nadpis, $popis, $datum, $id);
    $stmt->execute();

    // Zpracování nového obrázku
    if (isset($_FILES['novy_obrazek']) && $_FILES['novy_obrazek']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['novy_obrazek']['tmp_name'];
        $name_raw = basename($_FILES['novy_obrazek']['name']);
        $extension = strtolower(pathinfo($name_raw, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extension, $allowed_extensions)) {
            $name_clean = preg_replace("/[^a-zA-Z0-9-_\.]/", "", $name_raw);
            $final_name = time() . "-" . $name_clean;
            $target_path = "uploads/" . $final_name;

            if (move_uploaded_file($tmp_name, $target_path)) {
                $sql_img = "UPDATE novinky SET obrazek = ? WHERE id = ?";
                $stmt_img = $conn->prepare($sql_img);
                $stmt_img->bind_param("si", $target_path, $id);
                $stmt_img->execute();
            }
        }
    }

    header("Location: admin-panel.php");
    exit();
}
?>
