<?php

// Tonen van invoer
echo $_POST['naam'];
echo "<br>";
echo $_POST['adres'];
echo "<br>";
echo $_POST['email'];
echo "<br>";
echo $_POST['wachtwoord'];

// Uitkomst bij geen invoer
if ($_POST['naam'] == "") {
    echo "Je moet nog een naam invullen.";
    echo ">Terug naar het formulier.</a>";
}

if ($_POST['adres'] == "") {
    echo "Je moet nog een adres invullen.";
    echo ">Terug naar het formulier.</a>";
}

if ($_POST['email'] == "") {
    echo "Je moet nog een email invullen.";
    echo ">Terug naar het formulier.</a>";
}

if ($_POST['wachtwoord'] == "") {
    echo "Je moet nog een wachtwoord invullen.";
    echo ">Terug naar het formulier.</a>";
}