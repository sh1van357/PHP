<?php

session_start();

// Vernietig alle sessievariabelen
session_unset();

// Vernietig de sessie
session_destroy();

// Redirect naar de login pagina
header("Location: login.php");
exit;

