<?php

$twitch_client_id = 'uf1lmydha6dvfp8hejvov3ccnxnt9m';
$twitch_client_secret = '39two7kdl1fdvfpfo8un2ic5qg5cyk';
$twitch_scopes = '';

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
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: OAuth ' . $keys->access_token
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$r = curl_exec($ch);
$i = curl_getinfo($ch);
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
            echo 'Token close to expire. Regenerate';
            $generate_token = true;
        }
    } else {
        echo 'Failed to parse JSON. Assume dead token';
        $generate_token = true;
    }
}
} else { $generate_token = true; }

if ($generate_token) {
$ch = curl_init('https://id.twitch.tv/oauth2/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'client_id' => $client_id,
'client_secret' => $secret_id,
'grant_type' => "client_credentials"
));

$r = curl_exec($ch);
$i = curl_getinfo($ch);
curl_close($ch);

if ($i['http_code'] == 200) {
    $data = json_decode($r);
    if (json_last_error() == JSON_ERROR_NONE) {
        echo 'Got token';
        print_r($data);

        // store the token for next run
        file_put_contents(__DIR__ . '/auth.json', $r, JSON_PRETTY_PRINT);
    } else {
        echo 'Failed to parse JSON';
    }
} else {
    echo 'Failed with ' . $i['http_code'] . ' ' . $r;
}
} else {
echo 'Token OK';
print_r($keys);
}

$user = 'raythgaming';//Streamers username
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.twitch.tv/helix/streams?user_login=$user 2");//Endpoint
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
"Client-ID: $client_id",
"Authorization: Bearer " . $keys->access_token
));
$profile_data = json_decode(curl_exec($ch), true);
curl_close($ch);
print_r($profile_data);

if (!isset($profile_data['data'][0])) {
$live = 0;//Not live
} else {
$live = 1;//Is live
}

if ($live == 1) {
$title = $profile_data['data'][0]['title'];
$viewer_count = $profile_data['data'][0]['viewer_count'];
$game_id = $profile_data['data'][0]['game_id'];
$went_live_at = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s", strtotime($profile_data['data'][0]['started_at'])))->format('Y-m-d H:i:s');
$started = date_create($went_live_at);
$now = date_create(date('Y-m-d H:i:s'));
$diff = date_diff($started, $now);
$hours = $diff->h;
$minutes = $diff->i;
echo "$user is playing $game_name, started streaming $hours hours $minutes minutes ago and has $viewer_count viewers TITLE: $title";
} else {
echo "
$user is not live";
}
?>