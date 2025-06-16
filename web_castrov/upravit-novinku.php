<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nadpis = $_POST['nadpis'];
    $popis = $_POST['popis'];
    $datum = $_POST['datum'];

    $sql = "UPDATE novinky SET nadpis = ?, popis = ?, datum = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nadpis, $popis, $datum, $id);
    $stmt->execute();

    header("Location: admin-panel.php");
    exit();
}
?>
