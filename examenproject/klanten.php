<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klantenbeheer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1, h2 {
            text-align: center;
            color: #333;
            margin-top: 30px;
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

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="email"],
        .form-container textarea {
            width: 90%; /* Aangepast naar 90% */
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-container button {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table td button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        table td button:hover {
            background-color: #c82333;
        }

        table td form {
            display: inline;
        }
    </style>

</head>
<body>

<?php
// Database configuratie
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mydb';

$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_error) {
    die("Verbinding mislukt: " . $mysqli->connect_error);
}

include 'navbar.php';

// Klant toevoegen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $naam = $_POST['naam'];
    $achternaam = $_POST['achternaam'];
    $adres = $_POST['adres'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $email = $_POST['email'];
    $postcode = $_POST['postcode'];
    $wensen = $_POST['wensen'];
    $babys = $_POST['babys'] ?: 0;
    $kinderen = $_POST['kinderen'] ?: 0;
    $volwassenen = $_POST['volwassenen'] ?: 0;

    $stmt = $mysqli->prepare("INSERT INTO klanten (Naam, Achternaam, Adres, Telefoonnummer, `Email adres`, Postcode, Wensen, `Baby's`, Kinderen, Volwassenen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssiii", $naam, $achternaam, $adres, $telefoonnummer, $email, $postcode, $wensen, $babys, $kinderen, $volwassenen);

    if ($stmt->execute()) {
        echo "<p>Klant succesvol toegevoegd!</p>";
    } else {
        echo "<p>Er is een fout opgetreden: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Klant verwijderen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $klantnummer = $_POST['klantnummer'];

    $stmt = $mysqli->prepare("DELETE FROM klanten WHERE Klantnummer = ?");
    $stmt->bind_param("i", $klantnummer);

    if ($stmt->execute()) {
        echo "<p>Klant succesvol verwijderd!</p>";
    } else {
        echo "<p>Er is een fout opgetreden: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

$sql = "SELECT * FROM klanten";
$result = $mysqli->query($sql);
$klanten = $result->fetch_all(MYSQLI_ASSOC);
?>

<h1>Klantenbeheer</h1>

<!-- Klant toevoegen -->
<div class="form-container">
    <h2>Nieuwe Klant Toevoegen</h2>
    <form action="klanten.php" method="POST">
        <input type="hidden" name="action" value="add">
        <label for="naam">Naam:</label>
        <input type="text" name="naam" placeholder="Naam" required>
        <label for="achternaam">Achternaam:</label>
        <input type="text" name="achternaam" placeholder="Achternaam" required>
        <label for="adres">Adres:</label>
        <input type="text" name="adres" placeholder="Adres" required>
        <label for="telefoonnummer">Telefoonnummer:</label>
        <input type="text" name="telefoonnummer" placeholder="Telefoonnummer" required>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Email" required>
        <label for="postcode">Postcode:</label>
        <input type="text" name="postcode" placeholder="Postcode" required>
        <label for="wensen">Wensen:</label>
        <textarea name="wensen" placeholder="Wensen"></textarea>
        <label for="babys">Baby's:</label>
        <input type="number" name="babys" placeholder="Aantal baby's">
        <label for="kinderen">Kinderen:</label>
        <input type="number" name="kinderen" placeholder="Aantal kinderen">
        <label for="volwassenen">Volwassenen:</label>
        <input type="number" name="volwassenen" placeholder="Aantal volwassenen">
        <button type="submit">Toevoegen</button>
    </form>
</div>

<!-- Klantenlijst -->
<h2>Bestaande Klanten</h2>
<table>
    <thead>
    <tr>
        <th>Klantnummer</th>
        <th>Naam</th>
        <th>Achternaam</th>
        <th>Adres</th>
        <th>Telefoonnummer</th>
        <th>Email</th>
        <th>Postcode</th>
        <th>Wensen</th>
        <th>Baby's</th>
        <th>Kinderen</th>
        <th>Volwassenen</th>
        <th>Acties</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($klanten as $klant): ?>
        <tr>
            <td><?= $klant['Klantnummer'] ?></td>
            <td><?= htmlspecialchars($klant['Naam']) ?></td>
            <td><?= htmlspecialchars($klant['Achternaam']) ?></td>
            <td><?= htmlspecialchars($klant['Adres']) ?></td>
            <td><?= htmlspecialchars($klant['Telefoonnummer']) ?></td>
            <td><?= htmlspecialchars($klant['Email adres']) ?></td>
            <td><?= htmlspecialchars($klant['Postcode']) ?></td>
            <td><?= htmlspecialchars($klant['Wensen']) ?></td>
            <td><?= htmlspecialchars($klant['Baby\'s']) ?></td>
            <td><?= htmlspecialchars($klant['Kinderen']) ?></td>
            <td><?= htmlspecialchars($klant['Volwassenen']) ?></td>
            <td>
                <form action="klanten.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="klantnummer" value="<?= $klant['Klantnummer'] ?>">
                    <button type="submit">Verwijderen</button>
                </form>
                <form action="klanten_update.php" method="GET" style="display:inline;">
                    <input type="hidden" name="klantnummer" value="<?= $klant['Klantnummer'] ?>">
                    <button type="submit">Bewerken</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
$mysqli->close();
?>

</body>
</html>
