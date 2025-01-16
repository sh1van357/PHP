<?php

$server = "localhost";
$user = "root";
$pass = "";
$database = "vakantiepark2";


$conn = new mysqli($server, $user, $pass, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $bungalowNaam = $_POST['naam'];
    $bungalowLand = $_POST['land'];
    $bungalowPrijs = $_POST['prijs'];

    // Fetch columns from the 'bungalow' table
    $columnQuery = "SHOW COLUMNS FROM bungalows";
    $columnResult = mysqli_query($conn, $columnQuery);

    // Initialize columns and values arrays
    $columns = array();
    $values = array();

    if ($columnResult) {
        while ($columnRow = mysqli_fetch_assoc($columnResult)) {
            $columnName = $columnRow['Field'];

            // Skip 'id', 'naam', 'prijs', and 'land' columns
            if ($columnName != 'id' && $columnName != 'naam' && $columnName != 'prijs' && $columnName != 'land') {
                $columns[] = $columnName;

                // Check if the checkbox is set and assign 'ja' or 'nee' accordingly
                $values[] = isset($_POST[$columnName . '_checkbox']) ? 'ja' : 'nee';
            }
        }

        // Combine columns and values arrays into comma-separated strings
        $columnsString = implode(', ', $columns);
        $valuesString = "'" . implode("', '", $values) . "'";

        // Construct the dynamic SQL query
        $insertQuery = "INSERT INTO bungalows ($columnsString, naam, land, prijs) 
                        VALUES ($valuesString, '$bungalowNaam', '$bungalowLand', '$bungalowPrijs')";

        // Execute the query
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo '<script>alert("Bungalow Succesvol Toegevoegd!"); window.location.href = "index.php";</script>';
        } else {
            echo '<div class="container"><div class="alert alert-danger" role="alert">Error adding bungalow: ' . mysqli_error($conn) . '</div>';
        }
    } else {
        echo "Error fetching column names: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bungalow Toevoegen</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5 bg-dark text-white">
    <h2 class="mb-4">Bungalow Toevoegen</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" class="form-control bg-dark text-white" name="naam" required>
        </div>
        <div class="mb-3">
            <label for="land" class="form-label">Land:</label>
            <input type="text" class="form-control  bg-dark text-white" name="land" required>
        </div>
        <div class="mb-3">
            <label for="prijs" class="form-label">Prijs:</label>
            <input type="text" class="form-control  bg-dark text-white" name="prijs" required>
        </div>

        <!-- Checkbox list for additional columns -->
        <div class="mb-3">
            <label class="form-label">Voorzieningen:</label>

            <?php
            // Fetch columns from the 'bungalow' table
            $columnQuery = "SHOW COLUMNS FROM bungalow";
            $columnResult = mysqli_query($conn, $columnQuery);

            if ($columnResult) {
                while ($columnRow = mysqli_fetch_assoc($columnResult)) {
                    $columnName = $columnRow['Field'];

                    // Skip 'id', 'naam', 'prijs', and 'land' columns
                    if ($columnName != 'id' && $columnName != 'naam' && $columnName != 'prijs' && $columnName != 'land') {
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input bg-dark text-white' type='checkbox' name='{$columnName}_checkbox' ";
                        echo ">";
                        echo "<label class='form-check-label'>{$columnName}</label>";
                        echo "</div>";
                    }
                }
            } else {
                echo "Error fetching column names: " . mysqli_error($conn);
            }
            ?>
        </div>

        <a href="index.php" class="btn btn-secondary">Annuleren</a>
        <button type="submit" class="btn btn-primary">Toevoegen</button>
    </form>

    <!-- Bootstrap 5 JS (optional, for certain components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
