<?php
include 'db.php';
header('Content-Type: application/json');

$sql = "SELECT nadpis, popis, datum, obrazek FROM novinky";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$events = array();

while ($row = $result->fetch_assoc()) {
    if (!empty($row['datum'])) {
        $events[] = array(
            'title' => $row['nadpis'],
            'start' => date("Y-m-d\TH:i:s", strtotime($row['datum'])),
            'description' => $row['popis'],
            'image' => $row['obrazek']
        );
    }
}

echo json_encode($events);
?>
