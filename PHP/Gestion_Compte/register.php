<?php

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Merci de rentrer un nom d'utilisateur.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Un nom d'utilisateur ne peut contenir que des caractères alphanumériques et des underscores.";
    } else{
        // Prepare the JSON file containing the users
        $jsonfile_users = "./Users.json"
        $jsonString_users = file_get_contents($jsonfile_users);
        $data_users = json_decode($jsonString_users, true);

        // Set parameters
        $param_username = trim($_POST["username"]);

        if(isset($jsonString_users['Users']['$id'])){
            $username_err = "Ce nom d'utilisateur est déjà utilisé.";
        } else{
            $username = trim($_POST["username"]);
        }
    }
}

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Merci d'entrer un mot de passe.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Un mot de passe contient au moins 6 caractères.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Merci de confirmer votre mot de passe.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Les mots de passe ne correspondent pas.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // At the end, the new user's id will be: the highest id in the file + 1 
        // Initialize the highest id
        $highest_id = 0;

        //We browse the entire file
        foreach ($data_users as $a1) {
            foreach($a1 as $a){
                if ($a["id"] > $highest_id) {
                    $highest_id = $a["id"];
                }
            }
        }

        // Initalize the new user's id
        $new_id = $highest_id + 1;

        // Set parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

        // Add the user to the JSON file
        $data_users['Users'][] = array('username' => $param_username, 'password' => $param_password, 'id' => $new_id);
        $newJsonString = json_encode($data_users);
        file_put_contents($jsonfile_users, $newJsonString);

        // Redirect to login page
        header("location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>S'inscrire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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