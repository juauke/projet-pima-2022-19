<?php
// Initialize the session
session_start();

header("location: ../../index.html");
exit;

if (isset($_SESSION["loggedin"]))
{
$id = $_SESSION["loggedin"];
}


if (isset($_SESSION["id"]))
{
$id = $_SESSION["id"];
}

if (isset($_SESSION["username"]))
{
$username = $_SESSION["username"];
}

?>

<script>

sessionStorage.setItem("loggedin",<?php echo $loggedin; ?>);
sessionStorage.setItem("username",<?php echo $username; ?>);
sessionStorage.setItem("id",<?php echo $id; ?>);

</script>