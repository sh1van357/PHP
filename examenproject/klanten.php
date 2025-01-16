<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="stylesheet.css"> <!-- Optional: Link a global CSS file -->
</head>
<body>

<?php
// Database configuratie
$host = 'localhost'; // Of je serveradres
$username = 'root'; // Pas aan met je MySQL-gebruikersnaam
$password = ''; // Pas aan met je MySQL-wachtwoord
$database = 'mydb'; // Naam van de database

// Verbinding maken met MySQL-database
$mysqli = new mysqli($host, $username, $password, $database);

?>



<?php
include 'navbar.php'; // Navigatiebalk
include 'dbcon.php'; // Databaseverbinding //krijg ik niet werkend

// Query om gegevens van de tabel 'klanten' op te halen
$sql = "SELECT * FROM klanten";
$result = $mysqli->query($sql);




?>

</body>
</html>

