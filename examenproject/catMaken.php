<?php
session_start();
include 'dbcon.php';  // Zorg ervoor dat je de juiste databaseverbinding hebt

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verkrijg de naam van de nieuwe categorie
    $categorieNaam = $_POST['categorieNaam'];

    // Controleer of de naam niet leeg is
    if (!empty($categorieNaam)) {
        // Voorbereiden van de SQL-query zonder idCategorie
        $stmt = $conn->prepare("INSERT INTO Categorie (Naam) VALUES (?)");
        $stmt->bind_param("s", $categorieNaam);

        // Voer de query uit
        if ($stmt->execute()) {
            echo "<p>Categorie succesvol toegevoegd!</p>";
        } else {
            echo "<p>Er is een fout opgetreden: " . $stmt->error . "</p>";
        }

        // Sluit de statement
        $stmt->close();
    } else {
        echo "<p>De naam van de categorie mag niet leeg zijn.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie Aanmaken</title>
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
        .form-container button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Categorie Aanmaken</h1>

<!-- Formulier om een nieuwe categorie toe te voegen -->
<div class="form-container">
    <form action="catMaken.php" method="POST">
        <label for="categorieNaam">Categorie Naam</label>
        <input type="text" id="categorieNaam" name="categorieNaam" placeholder="Voer de categorie naam in" required>

        <button type="submit">Categorie Toevoegen</button>
    </form>
</div>

</body>
</html>

<?php
// Sluit de databaseverbinding
$conn->close();
?>
