<?php
$headers = 'From: Forms@Brouwerskazen.co' . "\r\n" .
    'reply-to:' . $_SESSION["email"] . "\r\n";

mail(
    $_SESSION["email"],
    "Uw klacht bij Brouwerskazen ingedient!", "Bedankt voor het indienden van een klacht, uw klacht ging over: \n" .
    $_SESSION["about"] .
    "\nEn uw klacht was \n"
    . $_SESSION["complaint"] .
    "\nU krijgt gegarandeert binnen 24 uur van een van onze medewerkers een email terug!" .
    "\nDeze email was automatisch gegenereerd en kan niet beantwoordt worden",
    $headers
);
?>