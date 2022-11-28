<?php
// Initialize the session
session_start();

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




