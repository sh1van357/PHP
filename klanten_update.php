<?php
// Database configuratie
$host = 'localhost'; // Pas aan met je serveradres
$username = 'root'; // Pas aan met je MySQL-gebruikersnaam
$password = ''; // Pas aan met je MySQL-wachtwoord
$database = 'mydb'; // Naam van de database

// Verbinding maken met MySQL-database
$conn = new mysqli($host, $username, $password, $database);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleer of er een Klantnummer is doorgegeven via GET
if (isset($_GET['Klantnummer'])) {
    $klantnummer = $_GET['Klantnummer'];

    // Haal de klantgegevens op
    $sql = "SELECT * FROM klanten WHERE Klantnummer = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $klantnummer);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $klant = $result->fetch_assoc();
    } else {
        die("Klant niet gevonden.");
    }
} else {
    die("Geen Klantnummer opgegeven.");
}

// Verwerk het updateformulier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['Naam'];
    $achternaam = $_POST['Achternaam'];
    $adres = $_POST['Adres'];
    $telefoonnummer = $_POST['Telefoonnummer'];
    $email = $_POST['Email'];
    $postcode = $_POST['Postcode'];
    $wensen = $_POST['Wensen'];
    $babys = $_POST['Babys'];
    $kinderen = $_POST['Kinderen'];
    $volwassenen = $_POST['Volwassenen'];

    // Update query
    $sql = "UPDATE klanten SET 
                Naam = ?, 
                Achternaam = ?, 
                Adres = ?, 
                Telefoonnummer = ?, 
                `Email adres` = ?, 
                Postcode = ?, 
                Wensen = ?, 
                `Baby's` = ?, 
                Kinderen = ?, 
                Volwassenen = ?
            WHERE Klantnummer = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssiisi",
        $naam,
        $achternaam,
        $adres,
        $telefoonnummer,
        $email,
        $postcode,
        $wensen,
        $babys,
        $kinderen,
        $volwassenen,
        $klantnummer
    );

    if ($stmt->execute()) {
        echo "Klantgegevens succesvol bijgewerkt.";
        header("Location: klanten.php"); // Terug naar de klantenpagina
        exit;
    } else {
        echo "Er is een fout opgetreden: " . $stmt->error;
    }
}
?>

    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Klant Bijwerken</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            .form-container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .form-container label {
                font-size: 16px;
                color: #555;
                margin-bottom: 10px;
                display: block;
            }

            .form-container input,
            .form-container textarea {
                width: 95%;
                padding: 10px;
                margin: 8px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
            }

            .form-container button {
                width: 100%;
                padding: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .form-container button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>

    <div class="form-container">
        <h1>Klant Bijwerken</h1>
        <form method="POST">
            <label for="Naam">Naam</label>
            <input type="text" id="Naam" name="Naam" value="<?= htmlspecialchars($klant['Naam']) ?>" required>

            <label for="Achternaam">Achternaam</label>
            <input type="text" id="Achternaam" name="Achternaam" value="<?= htmlspecialchars($klant['Achternaam']) ?>" required>

            <label for="Adres">Adres</label>
            <input type="text" id="Adres" name="Adres" value="<?= htmlspecialchars($klant['Adres']) ?>" required>

            <label for="Telefoonnummer">Telefoonnummer</label>
            <input type="text" id="Telefoonnummer" name="Telefoonnummer" value="<?= htmlspecialchars($klant['Telefoonnummer']) ?>" required>

            <label for="Email">Email</label>
            <input type="email" id="Email" name="Email" value="<?= htmlspecialchars($klant['Email adres']) ?>" required>

            <label for="Postcode">Postcode</label>
            <input type="text" id="Postcode" name="Postcode" value="<?= htmlspecialchars($klant['Postcode']) ?>" required>

            <label for="Wensen">Wensen</label>
            <textarea id="Wensen" name="Wensen"><?= htmlspecialchars($klant['Wensen']) ?></textarea>

            <label for="Babys">Baby's</label>
            <input type="number" id="Babys" name="Babys" value="<?= htmlspecialchars($klant['Baby\'s']) ?>">

            <label for="Kinderen">Kinderen</label>
            <input type="number" id="Kinderen" name="Kinderen" value="<?= htmlspecialchars($klant['Kinderen']) ?>">

            <label for="Volwassenen">Volwassenen</label>
            <input type="number" id="Volwassenen" name="Volwassenen" value="<?= htmlspecialchars($klant['Volwassenen']) ?>">

            <button type="submit">Bijwerken</button>
        </form>
    </div>

    </body>
    </html>
<?php
