<?php
$conn = new mysqli("localhost", "root", "", "castrov_web");
$conn->set_charset("utf8");

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
$nadpis = $conn->real_escape_string($_POST["nadpis"]);
$popis = $conn->real_escape_string($_POST["popis"]);
$obrazek = "";

// Zpracování obrázku, pokud je nahrán
if (isset($_FILES["obrazek"]) && $_FILES["obrazek"]["error"] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . time() . "-" . basename($_FILES["obrazek"]["name"]);
    if (move_uploaded_file($_FILES["obrazek"]["tmp_name"], $target_file)) {
        $obrazek = $conn->real_escape_string($target_file);
    }
}
if (isset($_FILES["novy_obrazek"]) && $_FILES["novy_obrazek"]["error"] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . time() . "-" . basename($_FILES["novy_obrazek"]["name"]);
    if (move_uploaded_file($_FILES["novy_obrazek"]["tmp_name"], $target_file)) {
        $obrazek = $conn->real_escape_string($target_file);
    }
}

if ($id > 0) {
    // Aktualizace novinky
    $datum = $_POST["datum"];
$datum = str_replace("T", " ", $datum) . ":00";
$datum = $conn->real_escape_string($datum);
$sql = "UPDATE novinky SET nadpis='$nadpis', popis='$popis', datum='$datum'";
    if (!empty($obrazek)) {
        $sql .= ", obrazek='$obrazek'";
    }
    $sql .= " WHERE id=$id";
} else {
    // Nová novinka
    $datum = $_POST["datum"];
$datum = str_replace("T", " ", $datum) . ":00";
$datum = $conn->real_escape_string($datum);
$sql = "INSERT INTO novinky (nadpis, popis, obrazek, datum) VALUES ('$nadpis', '$popis', '$obrazek', '$datum')";
}

if ($conn->query($sql)) {
    header("Location: admin-panel.php");
    exit;
} else {
    echo "❌ Chyba: " . $conn->error;
}
$conn->close();
?>
