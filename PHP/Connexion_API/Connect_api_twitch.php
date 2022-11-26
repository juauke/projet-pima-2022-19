<?php
function getStreamer($username){
$client_id = "uf1lmydha6dvfp8hejvov3ccnxnt9m";
$secret_id = 'ekqluu4u101wjqsp98wtkht1wp64bn';
$keys = false;
if (file_exists( './auth.json')) {
$keys = json_decode(file_get_contents( './auth.json'));
}

$generate_token = true;
if ($keys) {
// validate the token

$ch = curl_init('https://id.twitch.tv/oauth2/validate');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: OAuth ' . $keys->access_token
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
if(curl_exec($ch) === false)
{
    echo 'Curl error : ' . curl_error($ch);
}
$r = curl_exec($ch);
//echo $r;
$i = curl_getinfo($ch);
//var_dump($i);
curl_close($ch);

if ($i['http_code'] == 200) {
    // the token appears good
    $generate_token = false;

    // optional to check the expires
    $data = json_decode($r);
    if (json_last_error() == JSON_ERROR_NONE) {
        if ($data->expires_in < 3600) {
            // less than an hour left
            // make a new token
           // echo 'Token close to expire. Regenerate';
            $generate_token = true;
        }
    } else {
        //echo 'Failed to parse JSON. Assume dead token';
        $generate_token = true;
    }
}
} else { $generate_token = true; }

if ($generate_token) {
$ch = curl_init('https://id.twitch.tv/oauth2/token');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'client_id' => $client_id,
'client_secret' => $secret_id,
'grant_type' => "client_credentials"
));
if(curl_exec($ch) === false)
{
    echo 'Curl error: ' . curl_error($ch);
}
$r = curl_exec($ch);
$i = curl_getinfo($ch);
//var_dump($i);
curl_close($ch);

if ($i['http_code'] == 200) {
    $data = json_decode($r);
    if (json_last_error() == JSON_ERROR_NONE) {
        //echo 'Got token';
        //print_r($data);

        // store the token for next run
        file_put_contents(__DIR__ . '/auth.json', $r, JSON_PRETTY_PRINT);
    } else {
       // echo 'Failed to parse JSON';
    }
} else {
    //echo 'Failed with ' . $i['http_code'] . ' ' . $r;
}
} else {
//echo 'Token OK';
//print_r($keys);
}//Streamers username
$ch = curl_init();
//echo $keys->access_token;
curl_setopt($ch, CURLOPT_URL, "https://api.twitch.tv/helix/users?login=$username");//Endpoint
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-type: application/json',
    "Authorization: Bearer $keys->access_token",
    "Client-ID: $client_id"
));
if(curl_exec($ch) === false)
{
    echo 'Curl error: ' . curl_error($ch);
}
$profile_data = json_decode(curl_exec($ch), true);

$i=curl_getinfo($ch);
//var_dump($i);
curl_close($ch);
//echo json_encode($profile_data);
if(empty($profile_data["data"])){
    return "NULL";
}
else{
$id=$profile_data["data"][0]["id"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.twitch.tv/helix/users/follows?to_id=$id");//Endpoint
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-type: application/json',
    "Authorization: Bearer $keys->access_token",
    "Client-ID: $client_id"
));
if(curl_exec($ch) === false)
{
    echo 'Curl error: ' . curl_error($ch);
}
$i=curl_getinfo($ch);
$data2=json_decode(curl_exec($ch), true);
$nb_videos=0;
$page_left=true;
//echo json_encode($data2["total"]);
$lien_vers_autre_page='null';
while($page_left==true){
$ch = curl_init();
if($lien_vers_autre_page=='null'){
curl_setopt($ch, CURLOPT_URL, "https://api.twitch.tv/helix/videos/?user_id=$id&first=100");}//Endpoint
else
{
    curl_setopt($ch, CURLOPT_URL, "https://api.twitch.tv/helix/videos/?user_id=$id&first=100&after=$lien_vers_autre_page");
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-type: application/json',
    "Authorization: Bearer $keys->access_token",
    "Client-ID: $client_id"
));
if(curl_exec($ch) === false)
{
    echo 'Curl error: ' . curl_error($ch);
}

$data3=json_decode(curl_exec($ch), true);
$nb_videos+=(int) count($data3["data"]);
//echo $nb_videos;
//echo json_encode($data3["pagination"]);
if(json_encode($data3["pagination"])=='[]'){
    $page_left=false;
}
else{
    $lien_vers_autre_page=$data3["pagination"]["cursor"];
    //echo json_encode($lien_vers_autre_page);
}
}
return array("name"=>$username,"pop"=>(int)json_encode($data2["total"]),"sub"=>$profile_data["data"][0]["view_count"],"vc"=>$nb_videos,"images"=>$profile_data["data"][0]["profile_image_url"],"url"=>"https://www.twitch.tv/$username");}}

$l=getStreamer($_GET["name"]);
if($l!="NULL"){
echo json_encode($l);}
else{
    echo "NULL";
}
?>
