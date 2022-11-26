<?php

require("db.php");
//@requires : database name and user id
//@assigns : nothing
//@returns : all the influencers followed by the user in an array
function find_influencers_of_user(string $database_name, int $id_user){
    //Connecting to the database
    $conn = connectToDatabase($database_name);
    $sql1 = "SELECT instagram, spotify, twitch, youtube FROM following_data WHERE id = $id_user";
    $res1 = $conn->query($sql1);
    $res1->execute(); 
    $id_existing = $res1->fetchAll();

    $instagram_ids = $id_existing[0]['instagram'];
    $spotify_ids = $id_existing[0]['spotify'];
    $twitch_ids = $id_existing[0]['twitch'];
    $youtube_ids = $id_existing[0]['youtube'];

    $array_instagram = implode(',', array_map('intval', explode(',', $instagram_ids)));
    $array_spotify = implode(',', array_map('intval', explode(',', $spotify_ids)));
    $array_twitch = implode(',', array_map('intval', explode(',', $twitch_ids)));
    $array_youtube = implode(',', array_map('intval', explode(',', $youtube_ids)));

    $sql1 = "SELECT * FROM instagram WHERE id IN ($array_instagram)";
    $res1 = $conn->query($sql1);
    $res1 = $res1->fetchAll();
    $sql2 = "SELECT * FROM spotify WHERE id IN ($array_spotify)";
    $res2 = $conn->query($sql2);
    $res2 = $res2->fetchAll();
    $sql3 = "SELECT * FROM twitch WHERE id IN ($array_twitch)";
    $res3 = $conn->query($sql3);
    $res3 = $res3->fetchAll();
    $sql4 = "SELECT * FROM youtube WHERE id IN ($array_youtube)";
    $res4 = $conn->query($sql4);
    $res4 = $res4->fetchAll();

    $final_res = array_merge($res1, $res2, $res3, $res4);
    $conn = NULL;
    return $final_res;
}

?>