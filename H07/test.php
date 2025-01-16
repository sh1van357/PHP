<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $newBungalowType = $_POST["bungalow_type"];
    $newVoorzieningType = $_POST["voorziening_type"];

    // Insert new bungalow type into the 'bungalows' table
    $insertBungalowQuery = "INSERT INTO bungalows (type) VALUES (?)";
    $stmtBungalow = $conn->prepare($insertBungalowQuery);
    $stmtBungalow->bind_param("s", $newBungalowType);
    $stmtBungalow->execute();

    // Insert new voorziening type into the 'voorzieningen' table
    $insertVoorzieningQuery = "INSERT INTO voorzieningen (type) VALUES (?)";
    $stmtVoorziening = $conn->prepare($insertVoorzieningQuery);
    $stmtVoorziening->bind_param("s", $newVoorzieningType);
    $stmtVoorziening->execute();

    // Close prepared statements
    $stmtBungalow->close();
    $stmtVoorziening->close();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bungalow Type and Voorziening Type</title>
</head>
<body>

<h2>Add Bungalow Type and Voorziening Type</h2>

<form action="" method="POST">
    <label for="bungalow_type">Bungalow Type:</label>
    <input type="text" name="bungalow_type" required>
    <br><br>

    <label for="voorziening_type">Voorziening Type:</label>
    <input type="text" name="voorziening_type" required>
    <br><br>

    <input type="submit" value="Add">
</form>

</body>
</html>