<?php
// Initialize the session
session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Réinitialisation du mot de passe</h2>
    <p>Veuillez remplir ce formulaire pour réinitialiser votre mot de passe.</p>
    <form action="login.php" method="post">
        <div class="form-group">
            <label>Nouveau mot de passe</label>
            <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-group">
            <label>Confirmation mot de passe</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Soumettre">
            <a class="btn btn-link ml-2" href="welcome.php">Annuler</a>
        </div>
    </form>
</div>
</body>
</html>