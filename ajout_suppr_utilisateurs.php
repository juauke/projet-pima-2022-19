<?php
//Definition of functions for tasks A1, A2 and A3
//All these functions modify JSON files

//Function A1 : I don't know what to code

//Function A2
//@requires : A JSON file with the influencers, a JSON file with the users, the id of an influencer and the id of an user
//@assigns : Assigns the JSON file of the influencers. 
//The function add the user of the given id to the array of followers of the influencer 
//@returns : 1 if the file of the influencers was modified and 0 otherwise
//Throw an exception if the provided id do not exist
function add_follower(string $jsonfile_influencers, string $jsonfile_users, int $id_influencer, int $id_user){
    //We decode the files
    $jsonString_influencers = file_get_contents($jsonfile_influencers);
    $data_influencers = json_decode($jsonString_influencers, true);
    $jsonString_users = file_get_contents($jsonfile_users);
    $data_users = json_decode($jsonString_users, true);

    //We check if the both id exist in the files
    $test1 = -1;
    $test2 = 0;

    foreach ($data_influencers as $a1) {
        foreach($a1 as $a){
            $test1++;
        if ($a["id"] == $id_influencer) {
            break;
        }
        
    }
    break;
}
    if ($test1 == -1){
        throw new Exception("Influencer id not found");
    }
    foreach ($data_users as $a1) {
        foreach($a1 as $a){
        if ($a["id"] == $id_user) {
            $test2=1;
        }
    }}
    if ($test2 == 0){
        throw new Exception("User id not found");
    }
    
    //Now we modify the files 
    //First we check if the influencer is not already followed by the user
    //number of persons following the influencer
    $nb_followers = count($data_influencers["influenceurs_suivis"][$test1]["suivis_par"]);
    //test
    for($i = 0; $i < $nb_followers; $i++){
        //We compare
        if ($id_user == $data_influencers["influenceurs_suivis"][$test1]["suivis_par"][$i]){
            //the influencer is already followed by the user
            //We just re-encode the JSON file of the influencer 
            $newJsonString = json_encode($data_influencers);
            file_put_contents($jsonfile_influencers, $newJsonString);
            return 0;
        }
    }

    //Finally we modify the file 
    array_push($data_influencers["influenceurs_suivis"][$test1]["suivis_par"], $id_user);
    $newJsonString = json_encode($data_influencers);
    file_put_contents($jsonfile_influencers, $newJsonString);
    $test1=-1;
    return 1;
}


//Function A3
//@requires : A JSON file with the influencers, a JSON file with the users, the id of an influencer and the id of an user
//@assigns : Assigns the JSON file of the influencers. 
//The function delete the user of the given id from the array of followers of the influencer 
//@returns : 1 if the file of the influencers was modified and 0 otherwise
//Throw an exception if the provided id do not exist
function delete_follower(string $jsonfile_influencers, string $jsonfile_users, int $id_influencer, int $id_user){
    //We decode the files
    $jsonString_influencers = file_get_contents($jsonfile_influencers);
    $data_influencers = json_decode($jsonString_influencers, true);
    $jsonString_users = file_get_contents($jsonfile_users);
    $data_users = json_decode($jsonString_users, true);

    //We check if the both id exist in the files
    $test1 = -1;
    $test2 = 0;

    foreach ($data_influencers as $a1) {
        foreach($a1 as $a){
            $test1++;
        if ($a["id"] == $id_influencer) {
            break;
        }
        
    }
    break;
}
    if ($test1 == -1){
        throw new Exception("Influencer id not found");
    }
    foreach ($data_users as $a1) {
        foreach($a1 as $a){
        if ($a["id"] == $id_user) {
            $test2=1;
        }
    }}
    if ($test2 == 0){
        throw new Exception("User id not found");
    }
    
    //Now we modify the files 
    //First we check if the influencer is not followed by the user
    //number of persons following the influencer
    $nb_followers = count($data_influencers["influenceurs_suivis"][$test1]["suivis_par"]);
    //test
    $index = 0;
    $test3 = 0;
    for($i = 0; $i < $nb_followers; $i++){
        //We compare
        if ($id_user == $data_influencers["influenceurs_suivis"][$test1]["suivis_par"][$i]){
            //the influencer is followed by the user
            //We just re-encode the JSON file of the influencer 
            $test3 = 1;
            $index = $i;

        }
    }

    if($test3 == 0){
        $newJsonString = json_encode($data_influencers);
        file_put_contents($jsonfile_influencers, $newJsonString);
        return 0;
    }
    
    //Finally we modify the file 
    array_splice($data_influencers["influenceurs_suivis"][$test1]["suivis_par"], $index, 1);
    $newJsonString = json_encode($data_influencers);
    file_put_contents($jsonfile_influencers, $newJsonString);
    return 1;
}

?>