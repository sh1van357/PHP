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

// Haal productgegevens uit de database
$query = "SELECT * FROM product";
$result = $conn->query($query);

// Controleer of er producten zijn
if ($result->num_rows > 0) {
    $producten = $result->fetch_all(MYSQLI_ASSOC);  // Haal alle rijen op als een associatieve array
} else {
    $producten = [];
}

// Haal de categorieën op voor het dropdown-menu
$query_categorie = "SELECT * FROM categorie";
$result_categorie = $conn->query($query_categorie);
$categorieën = $result_categorie->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productbeheer</title>
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
        .form-container input[type="number"],
        .form-container select,
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

        .form-container .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Tabel styling */
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

        /* Toevoeging formulier styling */
        .add-product-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .add-product-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<h1>Productbeheer</h1>

<!-- Tabel voor productinformatie -->
<table>
    <thead>
    <tr>
        <th>Streepjescode</th>
        <th>Productnaam</th>
        <th>Aantal</th>
        <th>Categorie ID</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($producten) > 0): ?>
        <?php foreach ($producten as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['Streepjescode']) ?></td>
                <td><?= htmlspecialchars($product['Productnaam']) ?></td>
                <td><?= htmlspecialchars($product['Aantal']) ?></td>
                <td><?= htmlspecialchars($product['Categorie_idCategorie']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Geen producten gevonden.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<!-- Formulier om een nieuw product toe te voegen -->
<div class="form-container">
    <h2>Voeg een nieuw product toe</h2>
    <form id="addProductForm" action="add_product.php" method="POST">
        <label for="streepjescode">Streepjescode</label>
        <input type="number" id="streepjescode" name="streepjescode" placeholder="Voer de streepjescode in" required>

        <label for="productnaam">Productnaam</label>
        <input type="text" id="productnaam" name="productnaam" placeholder="Voer de productnaam in" required>

        <label for="aantal">Aantal</label>
        <input type="number" id="aantal" name="aantal" placeholder="Voer het aantal in" required>

        <label for="categorie_id">Categorie</label>
        <select id="categorie_id" name="categorie_id" required>
            <option value="" disabled selected>Kies een categorie</option>
            <?php foreach ($categorieën as $categorie): ?>
                <option value="<?= $categorie['idCategorie'] ?>"><?= $categorie['Naam'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Product Toevoegen</button>
    </form>
</div>

</body>
</html>

<?php
// Sluit de databaseverbinding
$conn->close();
?>
