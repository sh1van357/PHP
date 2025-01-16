<?php
// Toon fouten voor debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database-instellingen
$server = "localhost";
$user = "root";
$pass = "";
$database = "mydb";

// Verbinding maken met de database
$mysqli = new mysqli($server, $user, $pass, $database);

session_start();  // Zorg ervoor dat de sessie wordt gestart
echo "Sessie gestart.<br>";  // Debugging om te zien of de sessie is gestart

// Debugging: controleer of sessie-informatie is ingesteld
echo "User ID in session: " . ($_SESSION['user_id'] ?? 'Not Set') . "<br>";
echo "Gebruikersnaam in session: " . ($_SESSION['Gebruikersnaam'] ?? 'Not Set') . "<br>";

// Controleer of de verbinding is gelukt
if ($mysqli->connect_error) {
    die("Verbindingsfout: " . $mysqli->connect_error);
} else {
    echo "Verbonden met de database!<br>";
}

// Debugging: controleer de session ID
echo "Session ID: " . session_id() . "<br>";

// Als de gebruiker al is ingelogd, doorstuur naar index.php
if (isset($_SESSION['user_id'])) {
    echo "Gebruiker is al ingelogd, doorsturen naar index.php.<br>";
    header("Location: index.php");
    exit;
}

// Verwerk formulier bij POST-verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal de gebruikersnaam en wachtwoord op uit de POST-gegevens
    $gebruikersnaam = $_POST['Gebruikersnaam'] ?? '';
    $wachtwoord = $_POST['Wachtwoord'] ?? '';

    // Debug: toon ingevoerde gegevens
    echo "Gebruikersnaam: " . htmlspecialchars($gebruikersnaam) . "<br>";
    echo "Wachtwoord: " . htmlspecialchars($wachtwoord) . "<br>";

    // Zoek de gebruiker op basis van de gebruikersnaam
    $query = "SELECT * FROM accounts WHERE Gebruikersnaam = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind de gebruikersnaamparameter
        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $result = $stmt->get_result();

        // Controleer of de gebruiker bestaat
        if ($result->num_rows === 1) {
            $gebruiker = $result->fetch_assoc();

            // Debugging: toon de gegevens van de gebruiker
            echo "ID van gebruiker in database: " . $gebruiker['idAccounts'] . "<br>";  // We gebruiken idAccounts

            // Controleer of het wachtwoord correct is
            if (password_verify($wachtwoord, $gebruiker['Wachtwoord'])) {
                // Sla gebruikersinformatie op in de sessie
                $_SESSION['user_id'] = $gebruiker['idAccounts'];  // Gebruik idAccounts
                $_SESSION['Gebruikersnaam'] = $gebruiker['Gebruikersnaam'];

                // Sla de rol op in de sessie
                $_SESSION['Rollen_idRollen'] = $gebruiker['Rollen_idRollen'];  // Sla de rol op in de sessie

                // Debugging: controleer of sessie-informatie is ingesteld
                echo "Sessiedata is ingesteld!<br>";
                echo "User ID in sessie: " . $_SESSION['user_id'] . "<br>";
                echo "Gebruikersnaam in sessie: " . $_SESSION['Gebruikersnaam'] . "<br>";
                echo "Rol in sessie: " . $_SESSION['Rollen_idRollen'] . "<br>";  // Debugging rol

                // Redirect naar index.php
                header("Location: index.php");
                exit; // Zorg ervoor dat de code stopt na de redirect
            } else {
                $error = "Ongeldig wachtwoord.";
            }
        } else {
            $error = "Gebruikersnaam niet gevonden.";
        }

        $stmt->close();
    } else {
        $error = "Er is een fout opgetreden bij de query: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 30px;
        }

        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .login-container label {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
            display: block;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            border-color: #0056b3;
            outline: none;
        }

        .login-container button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="login-container">
    <h2>Inloggen</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <label>
            <input type="text" name="Gebruikersnaam" placeholder="Gebruikersnaam" required>
        </label>
        <label>
            <input type="password" name="Wachtwoord" placeholder="Wachtwoord" required>
        </label>
        <button type="submit">Inloggen</button>
    </form>
</div>

</body>
</html>
