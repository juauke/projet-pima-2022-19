<?php

require("db.php");
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