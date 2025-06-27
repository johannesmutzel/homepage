<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Honeypot-Spamschutz
  if (!empty($_POST["website"])) {
    http_response_code(403); // Forbidden
    exit;
  }

  // Eingaben bereinigen & validieren
  $name     = trim(htmlspecialchars($_POST["name"] ?? ''));
  $telefon  = trim(htmlspecialchars($_POST["telefon"] ?? ''));
  $email    = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
  $betreff  = trim(htmlspecialchars($_POST["betreff"] ?? ''));
  $nachricht = trim(htmlspecialchars($_POST["nachricht"] ?? ''));

  // E-Mail-Empfänger
  $empfaenger = "johannesmutzel2004@gmail.com";

  // Validierung
  if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($name) || empty($betreff) || empty($nachricht)) {
    echo "Bitte alle Pflichtfelder korrekt ausfüllen.";
    exit;
  }

  // E-Mail-Inhalt
  $subject = "Neue Kontaktanfrage: $betreff";
  $body = "Name: $name\nTelefon: $telefon\nE-Mail: $email\n\nNachricht:\n$nachricht";
  $headers = "From: johannesmutzel2004@gmail.com\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "Content-Type: text/plain; charset=utf-8";

  // Senden
  if (mail($empfaenger, $subject, $body, $headers)) {
    echo "Vielen Dank. Ihre Nachricht wurde erfolgreich übermittel. Wir melden uns schnellstmöglich bei Ihnen";
    exit;
  } else {
    echo "Nachricht konnte nicht gesendet werden. Bitte später erneut versuchen.";
  }
}
?>