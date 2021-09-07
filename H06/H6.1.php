<?php
try {
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "phpschool";

    $db = new PDO("mysql:host=" . $host . ";dbname=" . $database, $user, $password);
} catch (PDOException $error) {
    echo $error->getMessage();
    die();
}

$query = "select * from cursist";
$result = $db->query($query);
//if statement voor result
if ($result === false) {
    echo "Er is iets fout gegaan";
} else {
    foreach ($result as $row) {
        echo $row["cursistnr"] . "<br>";
        echo $row["naam"] . "<br>";
        echo $row["roepnaam"] . "<br>";
        echo $row["straat"] . "<br>";
        echo $row["postcode"] . "<br>";
        echo $row["plaats"] . "<br>";
        echo $row["plaats"] . "<br>";
        echo $row["geb_datum"] . "<br>";


    }
}

?>