
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

file_put_contents('log-email.txt', "Spouštím odeslani-emailu.php\n", FILE_APPEND);

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'cast.novinky@gmail.com';
    $mail->Password   = 'kbcwousbbsrxeobz';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->SMTPDebug = 2;  // Zapnuto ladění

    $mail->setFrom('cast.novinky@gmail.com', 'Obec Častrov');
    $mail->isHTML(true);
    $mail->Subject = 'Nová novinka na webu obce Častrov';
    $mail->Body    = 'Na webu obce Častrov byla přidána nová novinka. Podívejte se na ni!';

    require_once 'db.php';
    $subscribers = $conn->query("SELECT email FROM subscribers");

    if ($subscribers && $subscribers->num_rows > 0) {
        while ($row = $subscribers->fetch_assoc()) {
            $mail->addAddress($row['email']);
        }

        $mail->send();
        file_put_contents('log-email.txt', "E-maily byly odeslány: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    } else {
        file_put_contents('log-email.txt', "Žádní odběratelé nebo chyba v dotazu.\n", FILE_APPEND);
    }
} catch (Exception $e) {
    file_put_contents('log-email.txt', "Chyba při odesílání: {$mail->ErrorInfo}\n", FILE_APPEND);
    echo "CHYBA: " . $mail->ErrorInfo;
}
?>
