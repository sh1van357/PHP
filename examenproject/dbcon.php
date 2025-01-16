<?php



// Database configuratie
$host = 'localhost'; // Of je serveradres
$username = 'root'; // Pas aan met je MySQL-gebruikersnaam
$password = ''; // Pas aan met je MySQL-wachtwoord
$database = 'mydb'; // Naam van de database

// Verbinding maken met MySQL-database
$conn = new mysqli($host, $username, $password, $database);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Inlogfunctionaliteit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = $conn->real_escape_string($_POST['gebruikersnaam']);
    $wachtwoord = $conn->real_escape_string($_POST['wachtwoord']);

    $sql = "SELECT * FROM accounts WHERE gebruikersnaam = '$gebruikersnaam' AND wachtwoord = '$wachtwoord'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $gebruiker = $result->fetch_assoc();
        session_start();
        $_SESSION['gebruiker_id'] = $gebruiker['id'];
        $_SESSION['rol'] = $gebruiker['rol'];

        // Gebruiker naar de juiste pagina sturen op basis van de rol
        if ($gebruiker['rol'] === 'admin') {
            header('Location: admin_pagina.php');
        } elseif ($gebruiker['rol'] === 'gebruiker') {
            header('Location: gebruiker_pagina.php');
        } else {
            echo "Onbekende rol.";
        }
        exit;
    } else {
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
}

// Verbinding sluiten
$conn->close();

//simpel houden, voedselakketten samen stellen, product

//prdoducten toevoegen, klanten toevoegen en pakketten samenstellen.
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database connection successful!";
