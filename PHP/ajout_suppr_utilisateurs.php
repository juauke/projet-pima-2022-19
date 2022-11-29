<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("db.php");
//@requires : Name of the database the id of an user, id an influencer, name of social network ("instagram", "spotify", "twitch" or "youtube")
//@assigns : Assigns the database 
//add the influencer to the list of favorites of the user
//if the influencer is present on other SN, the associated ids are also added (automatic following everywhere)
//if the id user is not found, a new line with the provided id user is created
//@returns : nothing
function add_favorite(string $database_name, int $id_user, int $id_influencer, string $SN){
    //Connecting to the database
    $conn = connectToDatabase($database_name);

    //Checking if the id of the user is already in following_data
    $sql1 = "SELECT id FROM following_data WHERE id = $id_user";
    $res1 = $conn->query($sql1);
    $res1 = $res1->fetchAll();
    
    //If the id does not exist, we insert the line 
    if ($res1 == NULL){
        $sql2 = "INSERT INTO following_data (id, instagram, spotify, twitch, youtube) VALUES ($id_user, NULL, NULL, NULL, NULL)";
        $conn->query($sql2);
    }

    $sql3 = "SELECT instagram, spotify, twitch, youtube FROM following_data WHERE id = $id_user";
    $res2 = $conn->query($sql3);
    $res2->execute(); 
    $id_existing = $res2->fetchAll();

    if ($SN == "instagram"){
        $sql4 = "SELECT id_twitch, id_spotify, id_youtube FROM instagram WHERE id = $id_influencer";
        $res4 = $conn->query($sql4);
        $res4->execute();
        $id_to_add = $res4->fetchAll();

        $new_ids_insta = array_filter(explode(",", $id_existing[0]['instagram']));
        array_push($new_ids_insta, $id_influencer);
        $new_ids_insta = array_filter($new_ids_insta);

        $new_ids_twitch = array_filter(explode(",", $id_existing[0]['twitch']));
        array_push($new_ids_twitch, $id_to_add[0]['id_twitch']);
        $new_ids_twitch = array_filter($new_ids_twitch);

        $new_ids_spotify = array_filter(explode(",", $id_existing[0]['spotify']));
        array_push($new_ids_spotify, $id_to_add[0]['id_spotify']);
        $new_ids_spotify = array_filter($new_ids_spotify);

        $new_ids_youtube = array_filter(explode(",", $id_existing[0]['youtube']));
        array_push($new_ids_youtube, $id_to_add[0]['id_youtube']);
        $new_ids_youtube = array_filter($new_ids_youtube);
    }

    if ($SN == "spotify"){
        $sql4 = "SELECT id_insta, id_twitch, id_youtube FROM spotify WHERE id = $id_influencer";
        $res4 = $conn->query($sql4);
        $res4->execute();
        $id_to_add = $res4->fetchAll();

        $new_ids_insta = array_filter(explode(",", $id_existing[0]['instagram']));
        array_push($new_ids_insta, $id_to_add[0]['id_insta']);
        $new_ids_insta = array_filter($new_ids_insta);

        $new_ids_spotify = array_filter(explode(",", $id_existing[0]['spotify']));
        array_push($new_ids_spotify, $id_influencer);
        $new_ids_spotify = array_filter($new_ids_spotify);

        $new_ids_twitch = array_filter(explode(",", $id_existing[0]['twitch']));
        array_push($new_ids_twitch, $id_to_add[0]['id_twitch']);
        $new_ids_twitch = array_filter($new_ids_twitch);

        $new_ids_youtube = array_filter(explode(",", $id_existing[0]['youtube']));
        array_push($new_ids_youtube, $id_to_add[0]['id_youtube']);
        $new_ids_youtube = array_filter($new_ids_youtube);
    }

    if ($SN == "twitch"){
        $sql4 = "SELECT id_insta, id_spotify, id_youtube FROM twitch WHERE id = $id_influencer";
        $res4 = $conn->query($sql4);
        $res4->execute();
        $id_to_add = $res4->fetchAll();

        $new_ids_youtube = array_filter(explode(",", $id_existing[0]['youtube']));
        array_push($new_ids_youtube, $id_to_add[0]['id_youtube']);
        $new_ids_youtube = array_filter($new_ids_youtube);

        $new_ids_insta = array_filter(explode(",", $id_existing[0]['instagram']));
        array_push($new_ids_insta, $id_to_add[0]['id_insta']);
        $new_ids_insta = array_filter($new_ids_insta);

        $new_ids_spotify = array_filter(explode(",", $id_existing[0]['spotify']));
        array_push($new_ids_spotify, $id_to_add[0]['id_spotify']);
        $new_ids_spotify = array_filter($new_ids_spotify);

        $new_ids_twitch = array_filter(explode(",", $id_existing[0]['twitch']));
        array_push($new_ids_twitch, $id_influencer);
        $new_ids_twitch = array_filter($new_ids_twitch);
    }

    if ($SN == "youtube"){
        $sql4 = "SELECT id_insta, id_spotify, id_twitch FROM youtube WHERE id = $id_influencer";
        $res4 = $conn->query($sql4);
        $res4->execute();
        $id_to_add = $res4->fetchAll();

        $new_ids_insta = array_filter(explode(",", $id_existing[0]['instagram']));
        array_push($new_ids_insta, $id_to_add[0]['id_insta']);
        $new_ids_insta = array_filter($new_ids_insta);

        $new_ids_spotify = array_filter(explode(",", $id_existing[0]['spotify']));
        array_push($new_ids_spotify, $id_to_add[0]['id_spotify']);
        $new_ids_spotify = array_filter($new_ids_spotify);

        $new_ids_twitch = array_filter(explode(",", $id_existing[0]['twitch']));
        array_push($new_ids_twitch, $id_to_add[0]['id_twitch']);
        $new_ids_twitch = array_filter($new_ids_twitch);

        $new_ids_youtube = array_filter(explode(",", $id_existing[0]['youtube']));
        array_push($new_ids_youtube, $id_influencer);
        $new_ids_youtube = array_filter($new_ids_youtube);
    }

    $new_ids_insta = implode(",", $new_ids_insta);
    $new_ids_twitch = implode(",", $new_ids_twitch);
    $new_ids_spotify = implode(",", $new_ids_spotify);
    $new_ids_youtube = implode(",", $new_ids_youtube);

    //Update the database
    $sql5 = "UPDATE following_data SET instagram = '$new_ids_insta', spotify = '$new_ids_spotify', twitch = '$new_ids_twitch', youtube = '$new_ids_youtube' WHERE id = $id_user";
    $conn->query($sql5);

    //Deconnect
    $conn = NULL;
}


//@requires : Name of the database the id of an user, id an influencer, name of social network ("instagram", "spotify", "twitch" or "youtube")
//@assigns : Assigns the database 
//delete the influencer from the list of favorites of the user. Only one id is deleted, the one of the given SN.
//if the influencer was also followed on other SN, the associated ids remain
//@returns : nothing
function delete_favorite(string $database_name, int $id_user, int $id_influencer, string $SN){
    //Connecting to the database
    $conn = connectToDatabase($database_name);

    if ($SN == "instagram"){

        $sql1 = "SELECT instagram FROM following_data WHERE id = $id_user";
        $res1 = $conn->query($sql1);
        $res1->execute();
        $ids = $res1->fetchAll();

        $ids = explode(",", $ids[0]['instagram']);
        $pos = array_search($id_influencer, $ids);

        unset($ids[$pos]);

        $ids = implode(",", $ids);
        //Update the database
        $sql2 = "UPDATE following_data SET instagram = '$ids' WHERE id = $id_user";
        $conn->query($sql2);
    }

    if ($SN == "twitch"){

        $sql1 = "SELECT twitch FROM following_data WHERE id = $id_user";
        $res1 = $conn->query($sql1);
        $res1->execute();
        $ids = $res1->fetchAll();

        $ids = explode(",", $ids[0]['twitch']);
        $pos = array_search($id_influencer, $ids);

        unset($ids[$pos]);    

        $ids = implode(",", $ids);
        //Update the database
        $sql2 = "UPDATE following_data SET twitch = '$ids' WHERE id = $id_user";
        $conn->query($sql2);
    }

    if ($SN == "spotify"){

        $sql1 = "SELECT spotify FROM following_data WHERE id = $id_user";
        $res1 = $conn->query($sql1);
        $res1->execute();
        $ids = $res1->fetchAll();

        $ids = explode(",", $ids[0]['spotify']);
        $pos = array_search($id_influencer, $ids);

        unset($ids[$pos]);       

        $ids = implode(",", $ids);
        //Update the database
        $sql2 = "UPDATE following_data SET spotify = '$ids' WHERE id = $id_user";
        $conn->query($sql2);
    }

    if ($SN == "youtube"){

        $sql1 = "SELECT youtube FROM following_data WHERE id = $id_user";
        $res1 = $conn->query($sql1);
        $res1->execute();
        $ids = $res1->fetchAll();

        $ids = explode(",", $ids[0]['youtube']);
        $pos = array_search($id_influencer, $ids);

        unset($ids[$pos]);

        $ids = implode(",", $ids);
        //Update the database
        $sql2 = "UPDATE following_data SET youtube = '$ids' WHERE id = $id_user";
        $conn->query($sql2);
    }

    //Now we check if the removed influencer is still followed by a user.
    //If it is the case, we remove this user from the database 

    $sql3 = "SELECT $SN FROM following_data";
    $res3 = $conn->query($sql3);
    $res3 = $res3->fetchAll();

    $test = TRUE;
    foreach($res3 as $lignes){
        $ids = explode(",", $lignes[0]);
        $pos = array_search($id_influencer, $ids);
        if ($pos !== FALSE){
            $test = FALSE;
        }
    }

    if ($test == TRUE){
        $sql4 = "DELETE FROM $SN WHERE id = $id_influencer";
        $conn->query($sql4);
    }

    //Decennect
    $conn = NULL;
}
function add_influenceur(string $name,int $nbfollower,int $nbvideos,int $nbvues,string $url, string $image,string $database_name,string $SN){
    //Connecting to the database
    echo "test";
    $conn = connectToDatabase($database_name);
    $verif_exist="SELECT ID FROM $SN where url='$url'";
    var_dump($verif_exist);
    $res_verif=$conn->query($verif_exist);
    $res_verif=$res_verif->fetchAll();
    var_dump(empty($res_verif));
    if (empty($res_verif)){
    $query="INSERT INTO $SN(username,url,nb_subscribers,nb_videos,nb_views,image) VALUES ('$name','$url','$nbfollower','$nbvideos','$nbvues','$image')";
    $conn->query($query);
    $get_id="SELECT ID from $SN where url='$url'";
    $res=$conn->query($get_id);
    return $res->fetchAll();}
    else{
        return $res_verif;
    }
}

var_dump($_POST);
$action = $_POST["action"];
$dbName =  $_POST["dbName"];
$idUser = $_POST["idUser"];
$SocialN = $_POST["SocialN"];
$lien=$_POST["lien"];
$nom=$_POST["nom"];
$nbfollower=$_POST["nbfollower"];
$nbvideos=$_POST["nbvideos"];
$nbvues=$_POST["nbvues"];
$lien=$_POST["lien"];
$img=$_POST["img"];
//$idInfluencer=add_influenceur($nom,(int)$nbfollower,(int)$nbvideos,(int)$nbvues,$lien,$img,$dbName,$SocialN);
if($action = "ADD") {
    $idInfluencer=add_influenceur($nom,(int)$nbfollower,(int)$nbvideos,(int)$nbvues,$lien,$img,$dbName,$SocialN);
    var_dump($idInfluencer);
    add_favorite($dbName, $idUser, $idInfluencer[0]["ID"], $SocialN);
}

else if($action = "REMOVE") {
    delete_favorite($dbname, $idUser, $idInfluencer, $SocialN);
}


?>