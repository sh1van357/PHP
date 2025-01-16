<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Column Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
// Include the database connection file
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
    // Validate and sanitize input
    $columnName = filter_var($_POST["column_name"], FILTER_SANITIZE_STRING);

    // Query to add a new column to the 'bungalows' table with VARCHAR(10) and NOT NULL constraint
    $sql = "ALTER TABLE bungalow ADD COLUMN $columnName VARCHAR(10) NOT NULL";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Voorziening Succesvol Toegevoegd!"); window.location.href = "index.php";</script>';
    } else {
        echo '<div class="container"><div class="alert alert-danger" role="alert">Error adding column: ' . $conn->error . '</div>';
    }
}
?>

<!-- Form to add a new column -->
<div class="container mt-5">
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="mb-3">
            <label for="column_name" class="form-label">Nieuwe Voorziening:</label>
            <input type="text" class="form-control" id="column_name" name="column_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Voeg toe</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
