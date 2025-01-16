<?php 
session_start();
//server connection
$server = "localhost";
$user = "root";
$pass = "";
$database = "vakantiepark2";




$conn = new mysqli($server, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['email'])) {

    header("Location: login.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShivanWB | Bungalows</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">

    <!-- Bootstrap 5 css -->
    
    <!-- fontawesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- google font css -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- datatable (jquery) css -->
    <link rel="stylesheet" href="./datatablemap/css/dashboard.css">

</head>

<body>
    <br><br><br><br><br><br>

    <nav style="z-index:99;">
        <div class="logo">
            <i class="fa-solid fa-bars-staggered menu-icon"></i>
            <span class="logo-name menu-icon">Dashboard <img height="35" src="./images/dashboard/rocket.svg"> </span>
        </div>
        <div class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-xmark menu-icon"></i>
                <span class="logo-name menu-icon">Sluiten</span>
            </div>
            <div class="sidebar-content">
                <ul class="lists">
                    <li class="list">
                        <a href="index.php" class="nav-link active">
                        <i class="fa-solid fa-hotel icon"></i>
                            <span class="link">Bungalows</span>
                        </a>
                    </li>
                    <li class="list">
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="nav-link">
                        <i class="fa-solid fa-plus icon"></i>
                            <span class="link">Toevoegen</span>
                        </a>
                    </li>
                </ul>
                <div class="bottom-cotent">

                    <li class="list">
                        <a style="cursor: context-menu;" class="nav-link">
                            <i class="fa-solid fa-user icon"></i>
                            <span class="link"> <?php echo $_SESSION['email']; ?> </span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="logout.php" class="nav-link">
                            <i class="fa-solid fa-right-from-bracket icon"></i>
                            <span class="link">Uitloggen</span>
                        </a>
                    </li>


                </div>
            </div>
        </div>
    </nav>





    <div class="container mt-4 table-responsive">
        <div class="row mb-3">
            <div style="display:none;" class="col-md-6">
                <select style="background:  #141824; color: #bbd6fe; " id="soortFilter" class="form-select">
                    <option value="">Alles</option>
                    <option value="Turkije">Turkije</option>
                    <option value="Frankrijk">Frankrijk</option>
                </select>
            </div>

            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input style="background:  #141824; color: #bbd6fe; " type="text" class="form-control search-bar"
                        placeholder="Zoeken..." id="searchInput">
                </div>
            </div>
        </div>

        <table class="table table-bordered ">
            <thead class="table-primary">
                <tr>
                <th>Wijzigen</th>
                    <th>Bungalow_ID</th>
                    <th>Bungalow_naam</th>
                    <th>Prijs</th>
                    <th>Land</th>


                    <?php

$query = "SHOW COLUMNS FROM bungalows";
$result = mysqli_query($conn, $query);

if ($result) {
    

    while ($row = mysqli_fetch_assoc($result)) {
        $columnName = $row['Field'];


        if ($columnName != 'id' && $columnName != 'naam' && $columnName != 'prijs' && $columnName != 'land') {
            echo "<th>$columnName</th>";
        }
    }


} else {
    echo "Error: " . mysqli_error($conn);
}


?>


                    
                </tr>
            </thead>

            <?php

$query2 = "SELECT * FROM bungalows;";
$result2 = mysqli_query($conn, $query2);

while ($row = mysqli_fetch_assoc($result2)) {
    echo "<tr style='color:white !important;'>";

    echo "<td><a href='wijzigen.php?id={$row['id']}' class='btn btn-primary'><i class='fas fa-pencil-alt'></i></a></td>";
    // Loop through each column
    foreach ($row as $value) {
        echo "<td>$value</td>";
    }

    
    

    echo "</tr>";
}

?>





            <tbody>
        





            </tbody>
        </table>
    </div>




<!-- Bootstrap Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="z-index: 999999999;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Toevoegen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal content goes here -->
                <p>Wat wilt <?php echo $_SESSION['naam']; ?> toevoegen?</p>
                <a href="bungalow_toevoegen.php" type="button" class="btn btn-primary" >Bungalows Toevoegen</a>
                <a href="voorzieningen_toevoegen.php" type="button" class="btn btn-secondary" >Voorzieningen Toevoegen</a>
            </div>
        </div>
    </div>
</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   

    <script src="./js/index.js"></script>

</body>

</html>