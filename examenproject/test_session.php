<?php
session_start();

// Zet een sessie-variabele
$_SESSION['test'] = "Test succesvol";

// Toon sessie-inhoud
echo "Sessie-inhoud: <pre>";
print_r($_SESSION);
echo "</pre>";
?>
<?php
