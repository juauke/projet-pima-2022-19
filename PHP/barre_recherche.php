<?php
//Barre de recherche pour Krayt
require("db.php");

//@requires : database name and key word
//@assigns : nothing
//@returns : Results of the SQL query
function Search_Bar_PHP(string $database_name, string $word){
    //Connecting to the database
    $conn = connectToDatabase($database_name);

    //Preparing the request
    $stmt = $conn->query("SELECT * FROM (((instagram LEFT JOIN twitch ON instagram.id_twitch = twitch.id) LEFT JOIN spotify ON instagram.id_spotify = spotify.id) LEFT JOIN youtube ON instagram.id_youtube = youtube.id) WHERE (instagram.username LIKE 'in%' OR twitch.username LIKE 'in%' OR spotify.username LIKE 'in%' OR youtube.channel LIKE 'in%')");

    //Executing the request
    $stmt->execute();

    //Saving the result
    $resultSet = $stmt->fetchAll();

    var_dump($resultSet);

    return $resultSet;
}

Search_Bar_PHP("alexandre", "in");
?>