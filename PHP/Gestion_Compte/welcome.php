<?php
// Initialize the session
session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<h1 class="my-5">Bonjour, <b><?php echo htmlspecialchars($_POST["username"]); ?></b>. Bienvenue sur notre site.</h1>
<p>
    <a href="reset-password.php" class="btn btn-warning">Réinitialiser votre mot de passe</a>
    <a href="logout.php" class="btn btn-danger ml-3">Se déconnecter</a>
</p>
</body>
</html>