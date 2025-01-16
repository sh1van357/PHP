<?php
// Verbinding maken met de database
$server = "localhost";
$user = "root";
$pass = "";
$database = "mydb";

$mysqli = new mysqli($server, $user, $pass, $database);

// Controleer de verbinding
if ($mysqli->connect_error) {
    die("Verbindingsfout: " . $mysqli->connect_error);
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verkrijg de ingevoerde gegevens
    $gebruikersnaam = $_POST['Gebruikersnaam'];
    $wachtwoord = $_POST['Wachtwoord'];

    // Hash het wachtwoord
    $gehasht_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

    // Controleer of de gebruikersnaam al bestaat
    $query = "SELECT * FROM accounts WHERE Gebruikersnaam = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $gebruikersnaam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Deze gebruikersnaam is al in gebruik!";
    } else {
        // Als de gebruikersnaam nog niet bestaat, sla de gebruiker op in de database
        $insert_query = "INSERT INTO accounts (Gebruikersnaam, Wachtwoord) VALUES (?, ?)";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param("ss", $gebruikersnaam, $gehasht_wachtwoord);

        if ($stmt->execute()) {
            header("Location: login.php"); // Na registratie, doorverwijzen naar inlogpagina
            exit;
        } else {
            // Voeg foutmelding toe om de oorzaak te achterhalen
            $error = "Er is een fout opgetreden tijdens het registreren. Foutmelding: " . $stmt->error;
        }
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<!-- Navigatiebalk -->
<div class="navbar">
    <div class="title">Maaskantje</div>
    <div class="nav-links">
        <?php
        // Navigatiebalk links
        $navLinks = [
            'index' => 'Index',
            'voedselpakket' => 'Voedselpakket',
            'voorraad' => 'Voorraad',
            'productbeheer' => 'Productbeheer',
            'klanten' => 'Klanten',
            'accountbeheer' => 'Accountbeheer',
            'leveranciers' => 'Leveranciers',
            'login' => 'Login',
            'registreer' => 'Registreren'
        ];
        ?>
        <?php foreach ($navLinks as $url => $name): ?>
            <a href="<?= $url ?>.php"><?= $name ?></a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Registratieformulier -->
<div class="registration-container">
    <h2>Registreren</h2>
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <label for="Gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" id="Gebruikersnaam" name="Gebruikersnaam" required><br><br>

        <label for="Wachtwoord">Wachtwoord:</label>
        <input type="password" id="Wachtwoord" name="Wachtwoord" required><br><br>

        <button type="submit">Registreren</button>
    </form>
</div>

</body>
</html>
