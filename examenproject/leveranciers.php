<?php
session_start(); // Start de sessie
include 'navbar.php';
// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    // Als de gebruiker niet is ingelogd, stuur dan door naar de loginpagina
    header("Location: login.php");
    exit;
}

// Controleer de rol van de gebruiker
$rol = $_SESSION['Rollen_idRollen'] ?? null;

// Beperk toegang tot de pagina op basis van de rol
if ($rol != 2 && $rol != 3) { // Alleen rol 2 (magazijnmedewerker) en rol 3 (directeur) hebben toegang
    // Als de gebruiker geen rol 2 of rol 3 heeft, stuur dan door naar de homepage of een andere pagina
    header("Location: index.php");
    exit;
}
?>

    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Leveranciers</title>
    </head>
    <body>

    <h1>Leveranciers</h1>
    <p>Alleen toegankelijk voor magazijnmedewerkers en directeuren.</p>

    </body>
    </html>


