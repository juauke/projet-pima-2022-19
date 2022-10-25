<?php
//Requires my previous file
require("ajout_suppr_utilisateurs.php");
//Require function in_array, array_splice, file_get_contents, json_decode, file_put_contents

//G6

//Function returning an array of the influencers followed by an user
//@requires : A JSON file with the influencers, a JSON file with the users and the id of the user
//@assigns : nothing
//@returns : an array with the ids of the influencers followed by the user
//Throws exception when the id of the user does not exist
function find_influencers_of_user(string $jsonfile_influencers, string $jsonfile_users, string $id_user){
    //We decode the files
    $jsonString_influencers = file_get_contents($jsonfile_influencers);
    $data_influencers = json_decode($jsonString_influencers, true);
    $jsonString_users = file_get_contents($jsonfile_users);
    $data_users = json_decode($jsonString_users, true);

    //We check if the id of the user exists
    $id_exists = 0;

    foreach ($data_users as $a1) {
        foreach($a1 as $a){
            if ($a["id"] == $id_user){
                $id_exists = 1;
                break;
            }
        }
    }

    if ($id_exists == 0){
        throw new Exception("User id not found");
    }

    //We initialize the array of the id of the influencers followed by the user
    $followed_influencers = array();

    //Now we check each influencer
    $nb_influencers = count($data_influencers["influenceurs_suivis"]);
    for($i = 0; $i < $nb_influencers; $i++){
        if (in_array($id_user, $data_influencers["influenceurs_suivis"][$i]["suivis_par"])){
            $followed_influencers[] = $data_influencers["influenceurs_suivis"][$i]["id"];
        }
    }

    return $followed_influencers;
}


//Function allowing to add an user
//@requires : A JSON file with the users, the lastname of the new user, the firstname of the user
//the gender of the user, the picture (for the moment it is just a string)
//@assigns : Modify the JSON file
//@ensures : Add the user in the file with an appropriate id
//@returns : the id of the new user
//Throws exception when the gender is unknown
function add_user(string $jsonfile_users, string $lastname, string $firstname, string $gender, string $picture){
    //First of all we test if the gender is not unknown
    if ($gender != "Homme" and $gender != "Femme"){
        throw new Exception("Unknown gender");
    }

    //We decode the files
    $jsonString_users = file_get_contents($jsonfile_users);
    $data_users = json_decode($jsonString_users, true);

    //At the end value of the id of the new user will be : the highest id in the file + 1 
    //So we initialize the highest id
    $highest_id = 0;

    //We browse the entire file
    foreach ($data_users as $a1) {
        foreach($a1 as $a){
            if ($a["id"] > $highest_id) {
                $highest_id = $a["id"];
            }
        }
    }

    //Now we initalize the id of the new user
    $new_id = $highest_id + 1;

    //Finally we add the user in the file
    $data_users['Utilisateurs'][] = array('nom' => $lastname, 'prénom' => $firstname, 'genre' => $gender, 'image' => $picture, 'id' => $new_id);
    $newJsonString = json_encode($data_users);
    file_put_contents($jsonfile_users, $newJsonString);
    return $new_id;
}

//@requires : A JSON file with the users, A JSON file with the influencers and the id of the user to remove
//@assigns : Modify the JSON file
//@ensures : Remove the user from the users file and from the influencer file
//@returns : An array with the id of the influencers the user was following
//Throws exception when the provided value of id does not exist
//Use the function delete_follower 
function delete_user(string $jsonfile_influencers, string $jsonfile_users, string $id_user){

    //We decode the files
    $jsonString_users = file_get_contents($jsonfile_users);
    $data_users = json_decode($jsonString_users, true);
    $jsonString_influencers = file_get_contents($jsonfile_influencers);
    $data_influencers = json_decode($jsonString_influencers, true);

    //We browse the entire file to check if the provided id exists
    $test_id_existence = 0;

    //We also initialise the index of the user we want to remove (different from the id)
    $index_user_to_remove = 0;

    foreach ($data_users as $a1) {
        foreach($a1 as $a){
            if ($a["id"] == $id_user) {
                $test_id_existence = 1;
                break;
            }
            else{
                $index_user_to_remove = $index_user_to_remove + 1;
            }
        }
    }

    //If the id does not exist we throw an exception
    if ($test_id_existence == 0){
        throw new Exception("The provided id does not exist");
    }

    //We remove the user from the influencers file (before removing the user)
    //First we take the array with all the influencers followed by the user
    $followed_influencers = find_influencers_of_user($jsonfile_influencers, $jsonfile_users, $id_user);
    foreach($followed_influencers as $v){
        delete_follower($jsonfile_influencers, $jsonfile_users, $v, $id_user);
    }

    //We remove the associated user
    array_splice($data_users["Utilisateurs"], $index_user_to_remove, 1);
    $newJsonString = json_encode($data_users);
    file_put_contents($jsonfile_users, $newJsonString);

    return $followed_influencers;
}

?>