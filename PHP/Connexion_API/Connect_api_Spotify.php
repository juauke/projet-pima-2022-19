<?php

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
 
echo '<pre>'.print_r($json, true).'</pre>';
echo $json->access_token;
 
////////////////////////////// SECOND CALL!
$authorization = "Authorization: Bearer " . $json->access_token;
 
$artist = 'Tom Petty';
 
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
 
echo '<pre>'.print_r($json2, true).'</pre>';

?>