<?php
//Barre de recherche pour Krayt
require("db.php");

//@requires : database name and key word
//@assigns : nothing
//@returns : Results of the SQL query
function Search_Bar_PHP(string $database_name, string $word){
    //Connecting to the database
    if($word!=""){
    $res_final=[];
    $conn = connectToDatabase($database_name);
    //Preparing the request
    $stmt = $conn->query("SELECT * FROM  youtube where youtube.channel LIKE '%$word'");

    //Executing the request
    $stmt->execute();

    //Saving the result
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $cours){
	    $res_final[]=$cours;
    }

    $stmt = $conn->query("SELECT * FROM  twitch where twitch.username LIKE '%$word'");

    //Executing the request
    $stmt->execute();
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $cours){
	    $res_final[]=$cours;
    }

    $stmt = $conn->query("SELECT * FROM  spotify where spotify.username LIKE '%$word'");

    //Executing the request
    $stmt->execute();

    //Saving the result
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $cours){
	    $res_final[]=$cours;
    }
    return $res_final;}
    else{
        return "";
    }
}

$res=Search_Bar_PHP("alexandre", $_POST["name"]);
if($res==[]){
    echo '1';
}
else if($res==""){
    echo "";
}
else{
    //echo '1';
    echo json_encode($res);
}
?>