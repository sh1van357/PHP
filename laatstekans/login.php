<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "vakantiepark2";


$conn = new mysqli($server, $user, $pass, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();


$query = "SELECT * FROM accounts";

// Execute the query and retrieve the result
$result = mysqli_query($conn, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Fetch the first row
    $row = mysqli_fetch_assoc($result);

    // Retrieve the "naam" column value
    $naam = $row['naam'];
}

if (isset($_POST['submit'])) {
$email = $_POST['email'];
$password = $_POST['wachtwoord']; // Replace 'wachtwoord' with your form field name

// Retrieve the hashed password from the database based on the provided email
$query = "SELECT wachtwoord FROM accounts WHERE email='$email'";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashedPasswordFromDatabase = $row['wachtwoord'];

    // Verify the entered password against the stored hash
    if (password_verify($password, $hashedPasswordFromDatabase)) {
        // Successful login
        $query = "SELECT * FROM accounts WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['id'];
            $_SESSION['naam'] = $row['naam'];
            $_SESSION['email'] = $row['email'];

            header("Location: index.php"); // Redirect to dashboard
            exit;
        }
    } else {
        // Invalid login credentials
        echo "<script>alert('Onjuiste email of wachtwoord.')</script>";
    }
}
}

// Check if the user is already logged in
if (isset($_SESSION['naam']) || isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to dashboard if already logged in
    exit;
}




?>




<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>ShivanWB · Login</title>

	<!-- Icons -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!-- custom css -->
    <link rel="stylesheet" type="text/css" href="./css/LR.css">


    


</head>
<body>
<div class="container">
        <form action="" method="POST" class="login-email">
            
            <a href="index.php">
                <img style="height: 20vh; margin-bottom:15px; margin-left: 75px;" src="./images/login/login.svg">
            </a>

            <div class="input-group">
                <input id="inputplace" type="email" placeholder=" Email" name="email" required>
            </div>
            <div class="input-group">
                <input id="inputplace" type="password" placeholder="Wachtwoord" name="wachtwoord" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Login</button>
            </div>

        </form>
    </div>
</body>
</html>