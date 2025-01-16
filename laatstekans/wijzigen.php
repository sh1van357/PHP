<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "vakantiepark2";


$conn = new mysqli($server, $user, $pass, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controleer of een 'id'-parameter is opgegeven in de URL
if (isset($_GET['id'])) {
    $bungalowId = $_GET['id'];

    // Haal gegevens op voor de opgegeven bungalow
    $query = "SELECT * FROM bungalow WHERE id = $bungalowId";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Toon het formulier met vooraf ingevulde waarden
        $bungalowNaam = $row['naam'];
        $bungalowLand = $row['land'];
        $bungalowPrijs = $row['prijs'];
    } else {
        echo "Fout bij het ophalen van bungalowgegevens: " . mysqli_error($conn);
        exit;
    }
} else {
    echo "Fout: 'id'-parameter niet opgegeven.";
    exit;
}

// Controleer of het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data
    $geupdateNaam = $_POST['naam'];
    $geupdateLand = $_POST['land'];
    $geupdatePrijs = $_POST['prijs'];

    // Fetch column names from the 'bungalow' table
    $columnQuery = "SHOW COLUMNS FROM bungalow";
    $columnResult = mysqli_query($conn, $columnQuery);

    if ($columnResult) {
        // Initialize an array to store the columns and their values
        $updateColumns = array();

        while ($columnRow = mysqli_fetch_assoc($columnResult)) {
            $columnName = $columnRow['Field'];

            // Skip columns that are not user-editable
            if ($columnName != 'id' && $columnName != 'naam' && $columnName != 'land' && $columnName != 'prijs') {
                // Update the array with the new values
                $updateColumns[] = "$columnName = '" . (isset($_POST[$columnName . '_checkbox']) ? 'ja' : 'nee') . "'";
            }
        }

        // Combine the array elements into a comma-separated string for the SET clause
        $updateColumnsString = implode(", ", $updateColumns);

        // Update the database with the new values
        $updateQuery = "UPDATE bungalow SET 
            naam = '$geupdateNaam', 
            land = '$geupdateLand', 
            prijs = '$geupdatePrijs', 
            $updateColumnsString
            WHERE id = $bungalowId";

        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            // Toon een JavaScript-alert en ga naar index.php
            echo '<script>alert("Succesvol bijgewerkt"); window.location.href = "index.php";</script>';
            // Optioneel: je kunt ook header("Location: index.php"); gebruiken in plaats van de JavaScript-redirect
            // exit;
        } else {
            echo "Fout bij het bijwerken van bungalowgegevens: " . mysqli_error($conn);
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
    <title>Wijzigen Bungalow</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5 bg-dark text-white">
    <h2 class="mb-4">Wijzigen Bungalow</h2>
    <form action="" method="post">
        <input type="hidden" name="bungalowId" value="<?php echo $bungalowId; ?>">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" class="form-control bg-dark text-white" name="naam" value="<?php echo $bungalowNaam; ?>" required>
        </div>
        <div class="mb-3">
            <label for="land" class="form-label">Land:</label>
            <input type="text" class="form-control  bg-dark text-white" name="land" value="<?php echo $bungalowLand; ?>" required>
        </div>
        <div class="mb-3">
            <label for="prijs" class="form-label">Prijs:</label>
            <input type="text" class="form-control  bg-dark text-white" name="prijs" value="<?php echo $bungalowPrijs; ?>" required>
        </div>

        <!-- Checkbox list for additional columns -->
        <div class="mb-3">
            <label class="form-label">Voorzieningen:</label>

            <?php
            // Fetch column names from the 'bungalow' table
            $columnQuery = "SHOW COLUMNS FROM bungalow";
            $columnResult = mysqli_query($conn, $columnQuery);

            if ($columnResult) {
                while ($columnRow = mysqli_fetch_assoc($columnResult)) {
                    $columnName = $columnRow['Field'];

                    if ($columnName != 'id' && $columnName != 'naam' && $columnName != 'land' && $columnName != 'prijs') {
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input bg-dark text-white' type='checkbox' name='{$columnName}_checkbox' ";

                        // Check if the checkbox should be pre-selected based on the database value
                        echo ($row[$columnName] == 'ja') ? 'checked' : '';

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
        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>

    <!-- Bootstrap 5 JS (optional, for certain components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
