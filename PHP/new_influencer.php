<?php
    /**
     * @param string $name Name of the influencer.
     * @param int $id_user ID of the user.
     */
    function create_new_influencer($lastname, $firstname, $genre, $pseudo, $id_user){
        $data_location = "../data/influenceurs_suivis.json";
        $file=fopen($data_location, "r");
        $data = fread($file, filesize($data_location));
        fclose($file);

        $data = json_decode($data, true);
        $size = sizeof($data[1]);
        $data[1][$size] = array("nom" => $lastname, "prenom" => $firstname, "genre" => $genre, "pseudo" => $pseudo, "id" => $size, "suivi_par" => array($id_user));

        $file=fopen($data_location, "w");
        fwrite($file, json_encode($data));
        fclose($file);
    }
?>