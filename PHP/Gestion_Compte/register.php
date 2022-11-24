<?php
// Include config file
require_once "db.php";
$pdo = connectToDatabase('utilisateurs');

// Define variables and initialize with empty values
$email = $username = $password = $confirm_password = "";
$email_err = $username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Merci de rentrer une adresse mail.";
    } elseif (!filter_var(trim($_POST["email"], FILTER_VALIDATE_EMAIL))) {
        $email_err = "Une adresse mail de la forme \"utilisateur@domaine.suffixe\" est attendue.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM `primary_data` WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = htmlentities(trim($_POST["email"]));

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $email_err = "Cette adresse mail est déjà utilisée.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oups ! Quelque chose s'est mal passée. Merci de réessayer ultérieurement.";
            }

            // Close statement
            unset($stmt);
        }
    }  


    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Merci de rentrer un nom d'utilisateur.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Un nom d'utilisateur ne peut contenir que des caractères alphanumériques et des underscores.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM `primary_data` WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = htmlentities(trim($_POST["username"]));

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "Ce nom d'utilisateur est déjà utilisé.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oups ! Quelque chose s'est mal passée. Merci de réessayer ultérieurement.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Merci d'entrer un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Un mot de passe contient au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Merci de confirmer votre mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Les mots de passe ne correspondent pas.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare the call of the add user routine
        $sql = "INSERT INTO `primary_data` (username, email, passwd) VALUES (:username, :email, :password)"; // "CALL ADD_USER (:username, :email, :password)";
        
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_username = htmlentities($username);
            $param_email = htmlentities($email);
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Oups ! Quelque chose s'est mal passée. Merci de réessayer ultérieurement.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>S'inscrire</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>S'inscrire</h2>
    <p>Merci de remplir ce formulaire pour créer un compte.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Adresse mail</label>
            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <label>Confirmation mot de passe</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Soumettre">
            <input type="reset" class="btn btn-secondary ml-2" value="Réinitialiser">
        </div>
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </form>
</div>
</body>
</html>