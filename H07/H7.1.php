<?php
session_start();
//admin scherm na login

if (isset($_SESSION["gebruiker"]) && $_SESSION["gebruiker"]["rol"] == "Admin") {
    echo "<h1>Welkom ".$_SESSION["gebruiker"]. " op het admingedeelte van de website</h1>";
    echo "<p><a href='index.php'>Loginscherm</a></p>";
} else {
    header('location: index.php');
}
