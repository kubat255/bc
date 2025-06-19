
<?php
require_once 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    $email = trim($_POST["email"]);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT IGNORE INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            // Poslat potvrzovací e-mail
            $mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'cast.novinky@gmail.com';
                $mail->Password   = 'kbcwousbbsrxeobz';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('cast.novinky@gmail.com', 'Obec Častrov');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Potvrzení odběru novinek';
                $unsubscribe_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/unsubscribe.php?email=" . urlencode($email);
                $mail->Body = "Děkujeme za přihlášení k odběru novinek.<br><br>Pokud si to rozmyslíte, můžete se kdykoliv <a href='$unsubscribe_link'>odhlásit zde</a>.";

                $mail->send();
            } catch (Exception $e) {
                error_log("Chyba při odesílání potvrzení: {$mail->ErrorInfo}");
            }
            echo "Děkujeme za přihlášení k odběru novinek.";
        } else {
            echo "Chyba při ukládání e-mailu.";
        }
    } else {
        echo "Neplatná e-mailová adresa.";
    }
}
?>
