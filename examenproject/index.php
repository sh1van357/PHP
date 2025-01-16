<?php
session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    // Als de gebruiker niet is ingelogd, stuur dan door naar de loginpagina
    header("Location: login.php");
    exit;
}

// Controleer de rol van de gebruiker
if ($_SESSION['Rollen_idRollen'] == 1) {
    echo "Welkom, vrijwilliger!";
} elseif ($_SESSION['Rollen_idRollen'] == 2) {
    echo "Welkom, magazijnmedewerker!";
} elseif ($_SESSION['Rollen_idRollen'] == 3) {
    echo "Welkom, directeur!";
} else {
    echo "Onbekende rol.";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link a global CSS file -->
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'dbcon.php'; ?>

<h1>Welkom op de homepage van Maaskantje</h1>
<p>Dit is de homepage van de website.</p>

</body>
</html>

<?php
// Database configuratie
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mydb';

// Verbinding maken met MySQL-database
$conn = new mysqli($host, $username, $password, $database);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
