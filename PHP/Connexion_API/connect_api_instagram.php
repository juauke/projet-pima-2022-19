<?php
    $url="https://api.instagram.com/oauth/authorize";
    $client_id="805785450570662";
    $client_secret="6bb058c2ad75519cc6ecfeb9e746115e";
    $header = 0; // header = 0, because we do not have header
    $data2 = array(
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "redirect_uri" => "http://localhost",
    "grant_type" => "authorization_code",
    "code" => "AQBx-hBsH3"
    );
    $data= array(
        "client_id"=>$client_id,
    "redirect_uri"=>"https://localhost/Test/connect_api_instagram.php",
    "scope" =>"user_profile",
    "response_type"=>"code",
        );
    $curl = curl_init($url);    // we init curl by passing the url
curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
curl_setopt($curl,CURLOPT_POSTFIELDS,$data);   // indicate the data to send
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
$result = curl_exec($curl);
echo $result;   // to perform the curl session
curl_close($curl);   // to close the curl session

$user_data = json_decode($result,true);
//echo json_encode($user_data);
?>