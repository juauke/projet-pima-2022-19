<?php

require("db.php");

//Function adding a user to the database
//@requires : name of the database, username, email, and password
//@assigns : the database
//@returns : nothing, insert the new user
function add_user(string $database_name, string $username_, string $email_, string $password_){
    //Connecting to the database
    $conn = connectToDatabase($database_name);

    //SQL request
    $sql = "INSERT INTO primary_data (username, email, passwd) VALUES ('$username_', '$email_', '$password_')";

    //Execution of the SQL request
    $conn->query($sql);

    //Closing the connection
    $conn = null;
}

//Function removing a user from the database
//@requires : name of the database, user id
//@assigns : the database
//@returns : nothing, delete the user
function remove_user(string $database_name, int $id){
    //Connecting to the database
    $conn = connectToDatabase($database_name);

    //SQL requests
    $sql1 = "DELETE FROM following_data WHERE id = $id";
    $sql2 = "DELETE FROM primary_data WHERE id = $id";

    //Execution of the SQL requests
    $conn->query($sql1);
    $conn->query($sql2);

    //Closing the connection
    $conn = null;
}


?>