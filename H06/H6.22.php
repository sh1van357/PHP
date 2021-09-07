<?php
$login=false;
$user='root';
$pass='';

if ($_POST['email']=="piet@worldonline.nl"&& $_POST['wachtwoord']=='doetje123'){
    echo '<h1>Welkom Piet,</h1>';
    $login=true;

    try {
        $dbh = new PDO('mysql:host=localhost;dbname=phpschool;port=3306', $user, $pass);
        foreach($dbh->query('SELECT * from accounts') as $row) {
          //  print_r($row);
        }
        $dbh = null;
        //error message
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    die();
}
//emails die toegestaan zijn
if ($_POST['email']=="klaas@carpets.nl"&& $_POST['wachtwoord']=='snoepje777'){
    echo '<h1>Welkom Klaas,</h1>';
    $login=true;

    try {
        $dbh = new PDO('mysql:host=localhost;dbname=phpschool; port=3306', $user, $pass);
        foreach($dbh->query('SELECT * from accounts') as $row) {
           // print_r($row);
        }
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    die();
}

if ($_POST['email']=="truushendriks@wegweg.nl"&& $_POST['wachtwoord']=='arkiearkie201'){
    echo '<h1>Welkom Truus,</h1>';
    $login=true;

    try {
        $dbh = new PDO('mysql:host=localhost;dbname=phpschool; port=3306', $user, $pass);
        foreach($dbh->query('SELECT * from accounts') as $row) {
          //  print_r($row);
        }
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    die();
}

else{
    echo "<h1>U heeft geen toegang.</h1>";
}

?>