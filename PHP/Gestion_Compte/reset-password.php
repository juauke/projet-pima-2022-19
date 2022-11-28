<?php 

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../dependencies/PHPMailer-master/src/Exception.php';
require '../dependencies/PHPMailer-master/src/PHPMailer.php';
require '../dependencies/PHPMailer-master/src/SMTP.php';


// Connect to database
require_once("../db.php");
$pdo = connectToDatabase('utilisateurs');

// Define variables and initialize with empty values
$email = "";
$email_err = $query_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if username is empty
  if (empty(trim($_POST["email"]))) {
    $email_err = "Veuillez entrer votre adresse email.";
  } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
    $email_err = "Veuillez entrer une adresse mail valide.";
  } else {
    $email = trim($_POST["email"]);
  }

  // Validate email
  if (empty($email_err)) {
    // Prepare a select statement
    $sql = "SELECT id, email FROM `primary_data` WHERE email = :email";

    if ($stmt = $pdo->prepare($sql)) {
      // Bind email to the prepared statement as parameter
      $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

      // Set parameters
      $param_email = $email;

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Check if email exists, if so start process
        if ($stmt->rowCount() == 1) {
          // Prepare the update statement
          $sql2="UPDATE `primary_data` SET passwd = :password WHERE email = :email";

          if ($stmt2 = $pdo->prepare($sql2)) {
            // Bind email to the prepared statement as parameter
            $stmt2->bindParam(':email', $email);

            // Generate new password
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $max_len = strlen($chars);
            $new_password = '';
            for ($i = 0; $i < 10; $i++) {
                $new_password .= $chars[rand(0, $max_len - 1)];
            }
            
            $hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Bind new password to the prepared statement as parameter
            $stmt2->bindParam(':password', $hash);

            // Attempt to execute the prepared statement
            // If executed, then send an email with new password
            if ($stmt2->execute()) {

              $our_email = 'shriimpe@gmail.com';

              // Retrieve username from email
              $parts = explode('@', $email);
              $username = $parts[0];
              
              $entetes='From: '.$our_email;

              //Create a new PHPMailer instance; passing `true` enables exceptions
              $mail = new PHPMailer(true);

              try {
                  
                  //Server settings
              
                  //Enable SMTP debugging
                  //SMTP::DEBUG_OFF = off (for production use)
                  //SMTP::DEBUG_CLIENT = client messages
                  //SMTP::DEBUG_SERVER = client and server messages
                  $mail->SMTPDebug = SMTP::DEBUG_SERVER;
              
                  //Tell PHPMailer to use SMTP                    
                  $mail->isSMTP();                                            
              
                  $mail->SMTPOptions = array(
                      'ssl' => array(
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                      )
                      );
              
                  //Set the hostname of the mail server
                  $mail->Host = 'smtp.gmail.com';
                  //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
                  //if your network does not support SMTP over IPv6,
                  //though this may cause issues with TLS
              
                  //Whether to use SMTP authentication
                  $mail->SMTPAuth = true;
                  
                  //Username to use for SMTP authentication - use full email address for gmail
                  $mail->Username   = $our_email;
              
                  //Password to use for SMTP authentication
                  $mail->Password   = 'yzyityuqycfrdwul';
              
                  //Set the encryption mechanism to use:
                  // - SMTPS (implicit TLS on port 465) or
                  // - STARTTLS (explicit TLS on port 587)
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
              
                  //Set the SMTP port number:
                  // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
                  // - 587 for SMTP+STARTTLS
                  $mail->Port = 465;
                  //Recipients
                  
                  //Set who the message is to be sent from
                  //Note that with gmail you can only use your account address (same as `Username`)
                  //or predefined aliases that you have configured within your account.
                  //Do not use user-submitted addresses in here
                  $mail->setFrom($our_email, 'Shriimpe');
              
                  //Set who the message is to be sent to
                  $mail->addAddress($email, $username);
              
                  //Set an alternative reply-to address
                  //This is a good place to put user-submitted addresses
                  $mail->addReplyTo($our_email, 'Shriimpe');
              
                  // $mail->addCC('juauke@gmail.com');
                  $mail->addBCC($our_email);
              
                  //Content
                  $mail->isHTML(true);                                        //Set email format to HTML
                  $mail->Subject = 'Votre mot de passe';
                  $mail->msgHTML('<p>Bonjour</p><br>Veuillez trouver ci-joint votre mot de passe temporaire : '.$new_password);
                  $mail->AltBody = 'Bonjour, veuillez trouver ci-joint votre mot de passe temporaire : '.$new_password;
              
                  $mail->send();
                  
                  echo 'Un mail vient de vous être envoyé';
              
              } catch (Exception $e) {
                  echo "L'email n'a pas pu être envoyé. Erreur du Mailer : {$mail->ErrorInfo}";
              }}

              header("location: login.php");
              
            } else {
              echo "Oups ! Quelque chose s'est mal passée. Merci de réessayer ultérieurement.";
            } 
        } else {
          echo "Oups ! Quelque chose s'est mal passée. Merci de réessayer ultérieurement.";
        }
      } else {
        // Email doesn't exist, display a generic error message
        $query_err = "Adresse mail invalide.";
      }

      // Close statements
      unset($stmt);
      unset($stmt2);
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
    <title>Demande de mot de passe temporaire</title>
    <link rel="stylesheet" href="styles.css">
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="particles.js"></script>

    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div id="particles-js">
  <script type="text/javascript">
    //Fonction pour l'arrière plan
      $(document).ready(function () {


          particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 380,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "color": {
      "value": "#ffffff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#66FCF1"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.5,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 3,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#66FCF1",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 6,
      "direction": "none",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "grab"
      },
      "onclick": {
        "enable": true,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 140,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});
}
)
  </script>
</div>

<a href="welcome.php" class="btn btn-secondary">Retour à l'accueil</a>

<div class="wrapper">
    <h2>Demande de mot de passe temporaire</h2>
    <p>Merci d'indiquer votre adresse email afin de recevoir un mot de passe temporaire.</p>

    <?php
    if (!empty($query_err)) {
        echo '<div class="alert alert-danger">' . $query_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Demander un mot de passe temporaire">
        </div>
    </form>
</div>
</div>
</body>
</html>