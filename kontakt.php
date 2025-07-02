<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Honeypot
  if (!empty($_POST["website"])) {
    http_response_code(403);
    exit;
  }

  // Eingaben
  $name     = trim(htmlspecialchars($_POST["name"] ?? ''));
  $telefon  = trim(htmlspecialchars($_POST["telefon"] ?? ''));
  $email    = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
  $betreff  = trim(htmlspecialchars($_POST["betreff"] ?? ''));
  $nachricht = trim(htmlspecialchars($_POST["nachricht"] ?? ''));

  // Validierung
  if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($name) || empty($betreff) || empty($nachricht)) {
    echo "Bitte alle Pflichtfelder korrekt ausfüllen.";
    exit;
  }

  // PHPMailer einrichten
  $mail = new PHPMailer(true);

  try {
    // Servereinstellungen
    $mail->isSMTP();
    $mail->Host       = 'w00dda10.kasserver.com'; // oder dein SMTP-Server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'test@bihler-co.de'; // Absender-Adresse
    $mail->Password   = 'biba01'; // sicheres App-Passwort
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
    $mail->Port       = 587; // Port für TLS

    // Absender & Empfänger
    $mail->setFrom('test@bihler-co.de', 'Bihler Kontaktformular');
    $mail->addAddress('info@bihler-co.de'); // Empfänger
    $mail->addReplyTo($email, $name); // Antwort an den Kunden

    // Inhalt
    $mail->isHTML(false); // Plaintext reicht, oder auf true für HTML
    $mail->Subject = "Neue Kontaktanfrage: $betreff";
    $mail->Body    = 
"Name: $name
Telefon: $telefon
E-Mail: $email

Nachricht:
$nachricht";

    $mail->send();
    echo "Vielen Dank! Ihre Nachricht wurde erfolgreich übermittelt. Wir melden uns schnellstmöglich bei Ihnen.";
  } catch (Exception $e) {
    echo "Nachricht konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}";
  }
}
?>