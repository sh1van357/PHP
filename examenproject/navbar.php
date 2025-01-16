<?php

// Define an array for the navigation links
$navLinks = [
    'index' => 'Index',
    'voedselpakket' => 'Voedselpakket',
    'voorraad' => 'Voorraad',
    'productbeheer' => 'Productbeheer',
    'klanten' => 'Klanten',
    'accountbeheer' => 'Accountbeheer',
    'leveranciers' => 'Leveranciers',
    'login' => 'Login',
    'registreer' => 'Registreren'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maaskantje</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="navbar">
    <div class="title">Maaskantje</div>
    <div class="nav-links">
        <?php
        // Controleer de naam van de huidige pagina
        $currentPage = basename($_SERVER['PHP_SELF']);

        // Controleer of we op de registreren of login pagina zitten
        if ($currentPage == 'registreer.php'): ?>
            <!-- Alleen de login link tonen op de registreren-pagina -->
            <a href="login.php"><?= $navLinks['login'] ?></a>
        <?php elseif ($currentPage == 'login.php'): ?>
            <!-- Alleen de registreren link tonen op de login-pagina -->
            <a href="registreer.php"><?= $navLinks['registreer'] ?></a>
        <?php else: ?>
            <!-- Toon de andere links voor andere pagina's (behalve login en registreren) -->
            <?php foreach ($navLinks as $url => $name): ?>
                <?php if ($url != 'login' && $url != 'registreer'): ?>
                    <a href="<?= $url ?>.php"><?= $name ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
            <!-- Voeg de logout link toe als de gebruiker ingelogd is -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
