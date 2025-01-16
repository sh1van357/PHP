<?php
session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    // Als de gebruiker niet is ingelogd, stuur dan door naar de loginpagina
    header("Location: login.php");
    exit;
}

// Controleer de rol van de gebruiker
$rol = $_SESSION['Rollen_idRollen'] ?? null;

// Beperk toegang op basis van de rol
if ($rol != 3) { // Alleen de directeur (rol 3) heeft toegang
    // Als de gebruiker geen directeur is, stuur dan door naar de homepage of een andere pagina
    header("Location: index.php");
    exit;
}
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountbeheer</title>
</head>
<body>

<h1>Accountbeheer</h1>
<p>Alleen toegankelijk voor de directeur.</p>

</body>
</html>
