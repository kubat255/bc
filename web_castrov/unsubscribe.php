
<?php
require_once 'db.php';

if (isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    $stmt = $conn->prepare("DELETE FROM subscribers WHERE email = ?");
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        echo "Byl jste úspěšně odhlášen z odběru novinek.";
    } else {
        echo "Došlo k chybě při odhlašování.";
    }
} else {
    echo "Chybějící e-mail.";
}
?>
