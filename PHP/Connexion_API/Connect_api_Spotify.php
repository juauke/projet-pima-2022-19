<?php

//@requires : a string which represents the name of the artist (or the group) you are looking for
//@assigns : nothing
//@returns : A JSON file with information that was found after the search 
//Two possibilites :
// 1) There is no artist linked to this name, a empty file is returned
// 2) At least one artist was found, a JSON file is returned, the structure of the file is :
//
//{"Artistes":[{"followers" : integer(number of followers on Spotify), 
//              "genre" : string(The genre of the music, only one genre os written),
//              "image" : string(URL adress of the image of tge artist), 
//              "name" : string(The name of the artist),
//              "popularity" : int(On a scale from 0 to 100, the popularity of the artist according to Spotify)},
//             {SECOND RESULT},
//             {THIRD RESULT},
//             ...
//]}
//
//The file can be composed of a maximum of 20 elements (i.e 20 artists)

function Spotify(string $artiste){

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $client_id = 'df41af8c1a28444abc97b8a0e3d2d44a'; 
    $client_secret = '4da35a2198714f4890a4061540b32413';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,            'https://accounts.spotify.com/api/token' );
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret))); 
    curl_setopt($ch, CURLOPT_POSTFIELDS,     'grant_type=client_credentials' ); 
    curl_setopt($ch, CURLOPT_POST,           1 );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.x.x) Gecko/20041107 Firefox/x.x");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $json = curl_exec($ch);
    $json = json_decode($json);
    curl_close($ch);
    
    //echo '<pre>'.print_r($json, true).'</pre>';
    //echo $json->access_token;
    
    ////////////////////////////// SECOND CALL!
    $authorization = "Authorization: Bearer " . $json->access_token;
    
    $artist = $artiste;
    
    $spotifyURL = 'https://api.spotify.com/v1/search?q='.urlencode($artist).'&type=artist';
    
    $ch2 = curl_init();
    
    
    curl_setopt($ch2, CURLOPT_URL, $spotifyURL);
    curl_setopt($ch2,  CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.x.x) Gecko/20041107 Firefox/x.x");
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    $json2 = curl_exec($ch2);
    $json2 = json_decode($json2);
    curl_close($ch2);
    
    #echo '<pre>'.print_r($json2, true).'</pre>';

    return json_encode($json2);

}

?>